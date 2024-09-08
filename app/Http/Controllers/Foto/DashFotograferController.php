<?php

namespace App\Http\Controllers\Foto;

use App\Models\Foto;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashFotograferController extends Controller
{
    public function index()
    {
        $photographerId = Auth::id();

        $jumlahFotoTerjual = DetailPesanan::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->whereHas('pesanan', function ($query) {
            $query->where('status', 'Selesai')
                ->whereMonth('created_at', Carbon::now()->month) // Pesanan dari bulan saat ini
                ->whereYear('created_at', Carbon::now()->year);  // Pesanan dari tahun saat ini
        })->count();

        $jumlahFotoDiunggah = Foto::where('fotografer_id', $photographerId)
            ->whereMonth('created_at', Carbon::now()->month) // Mengambil data dari bulan ini
            ->whereYear('created_at', Carbon::now()->year)   // Mengambil data dari tahun ini
            ->count();

        $eventCount = Event::whereHas('foto', function ($query) use ($photographerId) {
            $query->where('fotografer_id', $photographerId);
        })->distinct()->count();

        return view('fotografer.dashboard', [
            "title" => "Dashboard Fotografer",
            "jumlahFotoTerjual" => $jumlahFotoTerjual,
            "jumlahFotoDiunggah" => $jumlahFotoDiunggah,
            "eventCount" => $eventCount,
        ]);
    }
}
