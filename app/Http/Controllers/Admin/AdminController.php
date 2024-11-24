<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Foto;
use App\Models\Event;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Withdrawal;

class AdminController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Menghitung jumlah foto yang terjual dalam bulan berjalan
        $jmlFotoTerjual = DetailPesanan::whereHas('pesanan', function ($query) {
            $query->where('status', 'Selesai'); // Filter berdasarkan status di tabel Pesanan
        })->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count('foto_id');

        $totalPenghasilan = Pesanan::where('status', 'Selesai')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('totalharga');

        $totalEventAktif = Event::whereIn('id', function ($query) {
            $query->select('event_id')
                ->from('foto')
                ->where('is_hapus', false); // Hanya foto yang belum dihapus
        })
            ->count();

        $fotoAktif = Foto::where('is_hapus', false)->count();

        $detailPesanan = DetailPesanan::whereHas('pesanan', function ($query) {
            $query->where('status', 'Selesai'); // Filter pesanan dengan status Selesai
        })->whereDate('created_at', Carbon::today())->get();
        
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

        $dailyRevenue = DetailPesanan::select(DB::raw('DAY(pesanan.created_at) as day'), DB::raw('SUM(foto.harga) as revenue'))
            ->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')  // Join ke pesanan
            ->where('pesanan.status', 'Selesai')
            ->whereMonth('pesanan.created_at', $currentMonth)  // Bulan berjalan
            ->whereYear('pesanan.created_at', $currentYear)    // Tahun berjalan
            ->groupBy(DB::raw('DAY(pesanan.created_at)'))
            ->get();


        // Ambil jumlah transaksi harian
        $dailySales = DetailPesanan::select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as sales'))
            ->whereHas('pesanan', function ($query) use ($currentMonth, $currentYear) {
                $query->where('status', 'Selesai')
                    ->whereMonth('created_at', $currentMonth)  // Bulan berjalan
                    ->whereYear('created_at', $currentYear);   // Tahun berjalan
            })
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();

        // Format data untuk dikirim ke frontend
        $days = range(1, Carbon::now()->daysInMonth);  // Semua hari dalam bulan ini
        $revenueData = [];
        $salesData = [];

        foreach ($days as $day) {
            $revenue = $dailyRevenue->firstWhere('day', $day);
            $sales = $dailySales->firstWhere('day', $day);

            // Jika tidak ada data untuk hari tersebut, set default nilai 0
            $revenueData[] = $revenue ? $revenue->revenue : 0;
            $salesData[] = $sales ? $sales->sales : 0;
        }

        $detailPesanan = DetailPesanan::whereHas('pesanan', function ($query) use ($startOfMonth, $endOfMonth) {
            $query->where('status', 'Selesai') // Hanya pesanan yang selesai
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth]); // Bulan berjalan
        })
            ->with(['foto.event', 'pesanan']) // Memuat relasi foto dan event terkait, serta pesanan
            ->get()
            ->map(function ($item) {
                $hargaFoto = $item->foto->harga;

                // Menghitung 11% dari harga foto
                $pendapatanDari11Persen = $hargaFoto * 0.11;

                // Menghitung 10% dari harga foto
                $pendapatanDari10Persen = $hargaFoto * 0.10;

                // Biaya admin tetap
                $biayaAdmin = 2000;

                // Total pendapatan = biaya admin + 11% dari harga + 10% dari harga
                $totalPendapatan = $biayaAdmin + $pendapatanDari11Persen + $pendapatanDari10Persen;

                return [
                    'id_pesanan' => $item->pesanan->id,  // ID Pesanan sebagai invoice
                    'event' => $item->foto->event->event ?? 'Event tidak tersedia', // Event terkait
                    'pendapatan' => $totalPendapatan, // Total pendapatan
                    'created_at' => $item->created_at, // Tanggal dibuat
                ];
            });

        $pembayaran = Withdrawal::where('status', 'Pending')->get();

        return view('admin.dashboard', [
            "title" => "Dashboard Admin",
            "jmlFotoTerjual" => $jmlFotoTerjual,
            "totalPenghasilan" => $totalPenghasilan,
            "totalEventAktif" => $totalEventAktif,
            "fotoAktif" => $fotoAktif,
            "totalPembelianBersih" => $totalPembelianBersih,
            "days" => $days,  // Tanggal
            "revenueData" => $revenueData,  // Data pendapatan harian
            "salesData" => $salesData,
            "detailPesanan" => $detailPesanan,
            "pembayaran" => $pembayaran,
        ]);
    }

    public function setting()
    {
        $user = auth()->user();

        return view('admin.setting', [
            "title" => "Setting",
            "user" => $user,
        ]);
    }
}
