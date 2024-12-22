<?php

namespace App\Http\Controllers\Foto;

use App\Models\Foto;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;

class DashFotograferController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $fotografer = $user->fotografer;

        if ($fotografer) {
            $photographerId = $fotografer->id;
        } else {
            // Tindakan jika user belum terdaftar sebagai fotografer
            $photographerId = null;
        }

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Menghitung jumlah foto terjual dalam bulan ini
        $jumlahFotoTerjual = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->whereHas('pesanan', function ($query) {
            $query->where('status', 'Selesai')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        })->count();

        // Menghitung jumlah foto diunggah dalam bulan ini
        $jumlahFotoDiunggah = Foto::where('fotografer_id', $photographerId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Menghitung jumlah event
        $eventCount = Event::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->distinct()->count();

        // Menghitung total pendapatan dari penjualan foto dalam bulan ini (dikurangi pajak 11%)
        $totalPendapatan = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->whereHas('pesanan', function ($query) {
            $query->where('status', 'Selesai')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        })->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->sum(DB::raw('foto.harga * 0.90'));  // Mengurangi pajak 11%

        // Menghitung total pendapatan dari penjualan foto hari ini (dikurangi pajak 11%)
        $totalPendapatanHarian = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->whereHas('pesanan', function ($query) {
            $query->where('status', 'Selesai')
                ->whereDate('created_at', Carbon::today());
        })->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->sum(DB::raw('foto.harga * 0.90'));  // Mengurangi pajak 11%

        // Data tambahan: Perhitungan penjualan per hari dalam bulan ini berdasarkan fotografer_id
        $dailyRevenue = DetailPesanan::select(DB::raw('DAY(pesanan.created_at) as day'), DB::raw('SUM(foto.harga * 0.90) as revenue'))
            ->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id') // Join ke pesanan
            ->where('pesanan.status', 'Selesai')
            ->where('foto.fotografer_id', $photographerId) // Filter berdasarkan fotografer_id
            ->whereMonth('pesanan.created_at', $currentMonth)
            ->whereYear('pesanan.created_at', $currentYear)
            ->groupBy(DB::raw('DAY(pesanan.created_at)'))
            ->get();

        // Ambil jumlah transaksi harian berdasarkan fotografer_id
        $dailySales = DetailPesanan::select(DB::raw('DAY(pesanan.created_at) as day'), DB::raw('COUNT(*) as sales'))
            ->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id') // Join ke pesanan
            ->where('pesanan.status', 'Selesai')
            ->where('foto.fotografer_id', $photographerId) // Filter berdasarkan fotografer_id
            ->whereMonth('pesanan.created_at', $currentMonth)
            ->whereYear('pesanan.created_at', $currentYear)
            ->groupBy(DB::raw('DAY(pesanan.created_at)'))
            ->get();

        // Format data untuk dikirim ke frontend
        $days = range(1, Carbon::now()->daysInMonth); // Semua hari dalam bulan ini
        $revenueData = [];
        $salesData = [];

        foreach ($days as $day) {
            $revenue = $dailyRevenue->firstWhere('day', $day);
            $sales = $dailySales->firstWhere('day', $day);

            // Jika tidak ada data untuk hari tersebut, set default nilai 0
            $revenueData[] = $revenue ? $revenue->revenue : 0;
            $salesData[] = $sales ? $sales->sales : 0;
        }

        $detailPesanan = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })
            ->whereHas('pesanan', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->where('status', 'Selesai') // Hanya pesanan yang selesai
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]); // Bulan berjalan
            })
            ->with(['foto.event', 'pesanan']) // Memuat relasi foto dan event terkait, serta pesanan
            ->get()
            ->map(function ($item) {
                // Menghitung pendapatan dikurangi pajak 11%
                $pendapatan = $item->foto->harga * 0.90;

                return [
                    'id_pesanan' => $item->pesanan->id,  // ID Pesanan sebagai invoice
                    'event' => $item->foto->event->event ?? 'Event tidak tersedia', // Event terkait
                    'pendapatan' => $pendapatan, // Pendapatan setelah dikurangi pajak
                    'created_at' => $item->created_at, // Pendapatan setelah dikurangi pajak
                ];
            });

        $withdrawal = Withdrawal::where('fotografer_id', $photographerId)
            ->whereYear('created_at', Carbon::now()->year)->get();

        $totalPembelianBersih = 0;

        $totalPembelianBersih = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->whereHas('pesanan', function ($query) {
            $query->where('status', 'Selesai')
                ->whereDate('created_at', Carbon::today());
        })->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->sum(DB::raw('foto.harga * 0.90'));
            
        // Kirim semua data ke view
        return view('fotografer.dashboard', [
            "title" => "Dashboard Fotografer",
            "jumlahFotoTerjual" => $jumlahFotoTerjual,
            "jumlahFotoDiunggah" => $jumlahFotoDiunggah,
            "eventCount" => $eventCount,
            "totalPendapatan" => $totalPendapatan,  // Bulanan
            "totalPendapatanHarian" => $totalPendapatanHarian,  // Harian
            "days" => $days,  // Tanggal
            "revenueData" => $revenueData,  // Data pendapatan harian
            "salesData" => $salesData,  // Data transaksi harian
            "detailPesanan" => $detailPesanan, // Data tabel detail pesanan yang ditampilkan
            "withdrawal" => $withdrawal,
            "totalPembelianBersih" => $totalPembelianBersih,
        ]);
    }

    public function index_search(Request $request)
    {
        $photographerId = Auth::id();

        // Ambil input tanggal dari request
        $inputTanggal = $request->input('tanggal');
        $tanggalAwal = null;
        $tanggalAkhir = null;

        // Cek jika input berupa rentang tanggal
        if (strpos($inputTanggal, 'to') !== false) {
            // Jika ada kata 'to', berarti ini rentang tanggal
            [$tanggalAwal, $tanggalAkhir] = explode(' to ', $inputTanggal);
            $tanggalAwal = Carbon::parse($tanggalAwal)->startOfDay();
            $tanggalAkhir = Carbon::parse($tanggalAkhir)->endOfDay();
        } else {
            // Jika hanya satu tanggal, set tanggal awal dan akhir menjadi sama
            $tanggalAwal = Carbon::parse($inputTanggal)->startOfDay();
            $tanggalAkhir = Carbon::parse($inputTanggal)->endOfDay();
        }

        // Menghitung jumlah foto terjual berdasarkan tanggal
        $jumlahFotoTerjual = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->whereHas('pesanan', function ($query) use ($tanggalAwal, $tanggalAkhir) {
            $query->where('status', 'Selesai')
                ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
        })->count();

        // Menghitung jumlah foto diunggah berdasarkan tanggal
        $jumlahFotoDiunggah = Foto::where('fotografer_id', $photographerId)
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->count();

        // Menghitung jumlah event
        $eventCount = Event::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->distinct()->count();

        // Menghitung total pendapatan dari penjualan foto dalam rentang tanggal (dikurangi pajak 11%)
        $totalPendapatan = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->whereHas('pesanan', function ($query) use ($tanggalAwal, $tanggalAkhir) {
            $query->where('status', 'Selesai')
                ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
        })->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->sum(DB::raw('foto.harga * 0.90'));  // Mengurangi pajak 11%

        // Menghitung total pendapatan harian berdasarkan input tanggal
        $dailyRevenue = DetailPesanan::select(DB::raw('DATE(pesanan.created_at) as day'), DB::raw('SUM(foto.harga * 0.90) as revenue'))
            ->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->where('pesanan.status', 'Selesai')
            ->whereBetween('pesanan.created_at', [$tanggalAwal, $tanggalAkhir])
            ->groupBy(DB::raw('DATE(pesanan.created_at)'))
            ->get();

        // Ambil jumlah transaksi harian berdasarkan input tanggal
        $dailySales = DetailPesanan::select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as sales'))
            ->whereHas('pesanan', function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->where('status', 'Selesai')
                    ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
            })
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Format data untuk dikirim ke frontend
        $days = collect(range(1, $tanggalAkhir->diffInDays($tanggalAwal) + 1));
        $revenueData = [];
        $salesData = [];

        foreach ($days as $day) {
            $revenue = $dailyRevenue->firstWhere('day', $tanggalAwal->addDays($day - 1)->toDateString());
            $sales = $dailySales->firstWhere('day', $tanggalAwal->addDays($day - 1)->toDateString());

            $revenueData[] = $revenue ? $revenue->revenue : 0;
            $salesData[] = $sales ? $sales->sales : 0;
        }

        // Ambil data detail pesanan berdasarkan rentang tanggal
        $detailPesanan = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })
            ->whereHas('pesanan', function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->where('status', 'Selesai')
                    ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir]);
            })
            ->with(['foto.event', 'pesanan'])
            ->get()
            ->map(function ($item) {
                $pendapatan = $item->foto->harga * 0.90;

                return [
                    'id_pesanan' => $item->pesanan->id,
                    'event' => $item->foto->event->event ?? 'Event tidak tersedia',
                    'pendapatan' => $pendapatan,
                    'created_at' => $item->created_at,
                ];
            });

        $totalPendapatanHarian = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->whereHas('pesanan', function ($query) {
            $query->where('status', 'Selesai')
                ->whereDate('created_at', Carbon::today());
        })->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->sum(DB::raw('foto.harga * 0.90'));  // Mengurangi pajak 11%


        $withdrawal = Withdrawal::where('fotografer_id', $photographerId)
            ->whereYear('created_at', Carbon::now()->year)->get();


        $totalPembelianBersih = 0;

        foreach ($detailPesanan->groupBy('pesanan_id') as $pesananId => $pesananGroup) {
            // Hitung biaya admin, ditambahkan hanya sekali per pesanan
            $biayaAdmin = 2000;
            $totalPerPesanan = $biayaAdmin;

            foreach ($pesananGroup as $detail) {
                // Ambil harga dari tabel foto berdasarkan foto_id
                $foto = Foto::find($detail->foto_id);
                $harga = (float) $foto->harga;

                // Hitung 11% dari harga dan 10% dari harga
                $potongan11 = 0.11 * $harga;
                $potongan10 = 0.10 * $harga;

                // Tambahkan potongan ke total per pesanan
                $totalPerPesanan += $potongan11 + $potongan10;
            }

            // Tambahkan total per pesanan ke total keseluruhan
            $totalPembelianBersih += $totalPerPesanan;
        }

        // Kirim semua data ke view
        return view('fotografer.dashboard', [
            "title" => "Dashboard Fotografer",
            "jumlahFotoTerjual" => $jumlahFotoTerjual,
            "jumlahFotoDiunggah" => $jumlahFotoDiunggah,
            "eventCount" => $eventCount,
            "totalPendapatan" => $totalPendapatan,
            "totalPendapatanHarian" => $totalPendapatanHarian,  // Harian
            "days" => $days,
            "revenueData" => $revenueData,
            "salesData" => $salesData,
            "detailPesanan" => $detailPesanan,
            "withdrawal" => $withdrawal,
            "totalPembelianBersih" => $totalPembelianBersih,
        ]);
    }
}
