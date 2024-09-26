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
use Illuminate\Support\Facades\Auth;

class DashFotograferController extends Controller
{
    public function index()
    {
        $photographerId = Auth::id();
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
            ->sum(DB::raw('foto.harga * 0.89'));  // Mengurangi pajak 11%

        // Menghitung total pendapatan dari penjualan foto hari ini (dikurangi pajak 11%)
        $totalPendapatanHarian = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->whereHas('pesanan', function ($query) {
            $query->where('status', 'Selesai')
                ->whereDate('created_at', Carbon::today());
        })->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->sum(DB::raw('foto.harga * 0.89'));  // Mengurangi pajak 11%

        // Data tambahan: Perhitungan penjualan per hari dalam bulan ini
        $dailyRevenue = DetailPesanan::select(DB::raw('DAY(pesanan.created_at) as day'), DB::raw('SUM(foto.harga * 0.89) as revenue'))
            ->join('foto', 'detail_pesanan.foto_id', '=', 'foto.id')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')  // Join ke pesanan
            ->where('pesanan.status', 'Selesai')
            ->whereMonth('pesanan.created_at', 9)
            ->whereYear('pesanan.created_at', 2024)
            ->groupBy(DB::raw('DAY(pesanan.created_at)'))
            ->get();


        // Ambil jumlah transaksi harian
        $dailySales = DetailPesanan::select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as sales'))
            ->whereHas('pesanan', function ($query) use ($currentMonth, $currentYear) {
                $query->where('status', 'Selesai')
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear);
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
                $pendapatan = $item->foto->harga * 0.89;

                return [
                    'id_pesanan' => $item->pesanan->id,  // ID Pesanan sebagai invoice
                    'event' => $item->foto->event->event ?? 'Event tidak tersedia', // Event terkait
                    'pendapatan' => $pendapatan, // Pendapatan setelah dikurangi pajak
                ];
            });
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
        ]);
    }
}
