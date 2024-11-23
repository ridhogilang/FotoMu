<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Earning;
use App\Models\Fotografer;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\DaftarFotografer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

        foreach ($fotografer as $fotograferItem) {
            // Ambil earning terbaru berdasarkan fotografer_id
            $earning = Earning::where('fotografer_id', $fotograferItem->id)
                ->orderBy('created_at', 'desc') // Ambil yang terbaru
                ->orderBy('id', 'desc')        // Hindari konflik
                ->value('jumlah');             // Ambil jumlah

            // Tambahkan ke properti sementara
            $fotograferItem->jumlah = $earning ?? 0; // Jika tidak ada, set ke 0
        }

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

        // Update data pengguna
        $user = User::findOrFail($daftarFotografer->user_id);
        $user->update([
            'is_foto' => true,
        ]);

        // Berikan role 'foto' kepada pengguna
        if (!$user->hasRole('foto')) { // Cegah duplikasi role
            $user->assignRole('foto');
        }

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

    public function pembayaran()
    {
        $pembayaran = Withdrawal::orderByRaw("FIELD(status, 'Pending') DESC")
            ->orderBy('created_at', 'desc') // Urutkan data lainnya berdasarkan tanggal
            ->get();

        return view('admin.pembayaran', [
            "title" => "Pembayaran",
            "pembayaran" => $pembayaran,
        ]);
    }
    public function pembayaran_proses(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
            'bukti_foto' => 'nullable|mimes:jpg,jpeg,png|max:2240',
            'pesan' => 'required|string|max:255',
        ]);

        // Temukan withdrawal berdasarkan ID
        $withdrawal = Withdrawal::findOrFail($id);

        // Upload file bukti foto jika ada
        $buktiFotoPath = $withdrawal->bukti_foto; // Default ke file yang sudah ada
        if ($request->hasFile('bukti_foto')) {
            // Hapus file lama jika ada
            if ($buktiFotoPath && Storage::exists($buktiFotoPath)) {
                Storage::delete($buktiFotoPath);
            }

            // Simpan file baru
            $buktiFotoPath = $request->file('bukti_foto')->store('bukti_transfer', 'public');
        }

        // Update withdrawal
        $withdrawal->update([
            'status' => $request->status,
            'bukti_foto' => $buktiFotoPath,
            'pesan' => $request->pesan,
            'processed_at' => now(),
        ]);

        // Jika status berubah menjadi Approved, buat record di tabel earning
        if ($request->status === 'Approved') {
            // Dapatkan jumlah terakhir dari earning berdasarkan fotografer_id
            $saldoTerakhir = Earning::where('fotografer_id', $withdrawal->fotografer_id)
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->value('jumlah') ?? 0;

            // Hitung jumlah baru setelah penarikan
            $jumlahBaru = $saldoTerakhir - $withdrawal->jumlah;

            // Buat entry baru di tabel earning
            Earning::create([
                'fotografer_id' => $withdrawal->fotografer_id,
                'withdrawal_id' => $withdrawal->id,
                'uang_keluar' => $withdrawal->jumlah,
                'jumlah' => $jumlahBaru,
                'status' => 'Penarikan',
            ]);
        }

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Pembayaran berhasil diproses.');
    }

    public function updateStatusFotografer(Request $request, $id)
    {
        // Validasi ID pengguna
        $user = User::findOrFail($id);

        // Periksa apakah checkbox dikirimkan dan dicentang
        $isFoto = $request->boolean('is_foto'); // Mengembalikan true jika checked, false jika unchecked

        // Update kolom is_foto
        $user->update(['is_foto' => $isFoto]);

        // Update hak role berdasarkan status checkbox
        if ($isFoto) {
            // Tambahkan role jika belum ada
            if (!$user->hasRole('foto')) {
                $user->assignRole('foto');
            }
        } else {
            // Hapus role jika ada
            if ($user->hasRole('foto')) {
                $user->removeRole('foto');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status Fotografer berhasil diperbarui.',
            'is_foto' => $isFoto
        ]);
    }
}
