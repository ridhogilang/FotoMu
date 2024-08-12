<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function formfoto()
    {
        return view('user.formfoto', [
            "title" => "Form Foto Depan",
        ]);
    }

    public function upload_fotodepan(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Periksa apakah ada file yang diupload
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Ambil nama pengguna yang sedang login
            $user = auth()->user();
            $username = $user->name; // Ganti dengan nama kolom yang sesuai di tabel pengguna

            if ($user->foto_depan) {
                $oldFilePath = str_replace('/storage/', 'public/', $user->foto_depan);
                if (Storage::exists($oldFilePath)) {
                    Storage::delete($oldFilePath);
                }
            }

            // Buat nama file dengan format username_fotodepan.ext
            $fileName = $username . '_fotodepan.' . $file->getClientOriginalExtension();

            // Simpan file ke direktori public/foto_user
            $path = $file->storeAs('public/foto_user', $fileName);

            // Ambil URL file
            $fileUrl = Storage::url($path);

            // Simpan URL file ke database
            $user->foto_depan = $fileUrl;
            $user->save();

            // Redirect ke halaman profil atau halaman lain
            return response()->json([
                'success' => true,
                'file_url' => $fileUrl,
                'redirect_url' => route('user.produk') // URL redirect setelah upload
            ]);
        }

        return response()->json(['error' => 'File upload failed'], 422);
    }
}
