<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPemesananController extends Controller
{
    public function riwayat()
    {
        $pemesanan = Pesanan::withCount('detailPesanan')->get();
        
        return view('admin.riwayat_pemesanan', [
            "title" => "Riwayat Pemesanan",
            "pemesanan" => $pemesanan,
        ]);
    }

    public function akumulasi()
    {
        $akumulasi = User::withCount(['pesananSelesai as jumlah_pesanan_selesai'])->get();
        
        return view('admin.jumlah_pemesanan', [
            "title" => "Akumulasi Pesanan",
            "akumulasi" => $akumulasi,
        ]);
    }
}
