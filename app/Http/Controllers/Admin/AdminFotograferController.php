<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DaftarFotografer;
use App\Models\Fotografer;

class AdminFotograferController extends Controller
{
    public function pendaftaran_fotografer()
    {
        $daftar = DaftarFotografer::where('is_validate', false)->get();
        return view('admin.pendaftaran_fotografer', [
            "title" => "Pendaftaran Fotografer",
            "daftar" => $daftar,
        ]);
    }

    public function fotografer()
    {
        $fotografer = Fotografer::with('user')->get();
        
        return view('admin.fotografer', [
            "title" => "Fotografer",
            "fotografer" => $fotografer,
        ]);
    }

    public function setujui_fotografer(Request $request, $id)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nowa' => 'required|numeric',
            'pesan' => 'required|string|min:20|max:100',
        ]);

        // Cari item di daftar_fotografer berdasarkan ID
        $daftarFotografer = DaftarFotografer::findOrFail($id);

        // Update kolom is_validate menjadi true jika disetujui
        $daftarFotografer->is_validate = true;
        $daftarFotografer->status = 'Diterima'; // Set status menjadi Diterima
        $daftarFotografer->save();

        // Jika disetujui, tambahkan data ke tabel fotografer
        Fotografer::create([
            'user_id' => $daftarFotografer->user_id,
            'nama' => $daftarFotografer->nama,
            'alamat' => $daftarFotografer->alamat,
            'nowa' => $daftarFotografer->nowa,
            'foto_ktp' => $daftarFotografer->foto_ktp, // Path foto tetap sama
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Fotografer berhasil di setujui!');
    }

    public function fotografer_reject($id)
    {
        // Cari item di daftar_fotografer berdasarkan ID
        $daftarFotografer = DaftarFotografer::findOrFail($id);

        // Update kolom is_validate menjadi true dan status menjadi 'Ditolak'
        $daftarFotografer->is_validate = true;
        $daftarFotografer->status = 'Ditolak';
        $daftarFotografer->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data event berhasil ditolak!');
    }
}
