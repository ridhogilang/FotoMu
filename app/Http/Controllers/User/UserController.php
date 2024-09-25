<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function formfoto_depan()
    {
        return view('user.formfoto_depan', [
            "title" => "Form Foto Depan",
        ]);
    }

    public function retake()
    {
        $userId = Auth::id();
        $user = User::where('id', $userId)->first();

        return view('user.retake', [
            "title" => "Perbaharui Foto",
            "user" => $user,
        ]);
    }

    public function robomu()
    {
        return view('user.robomu', [
            "title" => "Fitur Robomu",
        ]);
    }

    public function formfoto_kiri()
    {
        return view('user.formfoto_kiri', [
            "title" => "Form Foto Kiri",
        ]);
    }

    public function formfoto_kanan()
    {
        return view('user.formfoto_kanan', [
            "title" => "Form Foto Kanan",
        ]);
    }

    public function upload_fotodepan(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $user = auth()->user();
            $username = $user->name;

            // Hapus foto depan lama jika ada
            if ($user->foto_depan) {
                $oldFilePath = str_replace('/storage/', 'public/', $user->foto_depan);
                if (Storage::exists($oldFilePath)) {
                    Storage::delete($oldFilePath);
                }
            }

            // Buat nama file
            $fileName = $username . '_fotodepan.' . $file->getClientOriginalExtension();

            // Simpan file ke storage
            $path = $file->storeAs('public/foto_user', $fileName);

            // Simpan path relatif ke database (tanpa "/storage/")
            $relativePath = str_replace('public/', '', $path);

            $user->foto_depan = $relativePath;
            $user->save();

            return response()->json([
                'success' => true,
                'file_url' => $relativePath,
                'redirect_url' => route('user.produk')
            ]);
        }

        return response()->json(['error' => 'File upload failed'], 422);
    }


    public function upload_fotokiri(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $user = auth()->user();
            $username = $user->name;

            if ($user->foto_depan) {
                $oldFilePath = str_replace('/storage/', 'public/', $user->foto_kiri);
                if (Storage::exists($oldFilePath)) {
                    Storage::delete($oldFilePath);
                }
            }

            $fileName = $username . '_fotokiri.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('public/foto_user', $fileName);

            $fileUrl = Storage::url($path);

            $user->foto_kiri = $fileUrl;
            $user->save();

            return response()->json([
                'success' => true,
                'file_url' => $fileUrl,
                'redirect_url' => route('user.formfotokanan')
            ]);
        }

        return response()->json(['error' => 'File upload failed'], 422);
    }

    public function upload_fotokanan(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $user = auth()->user();
            $username = $user->name;

            // Hapus foto depan lama jika ada
            if ($user->foto_kanan) {
                $oldFilePath = str_replace('/storage/', 'public/', $user->foto_kanan);
                if (Storage::exists($oldFilePath)) {
                    Storage::delete($oldFilePath);
                }
            }

            // Buat nama file
            $fileName = $username . '_fotokanan.' . $file->getClientOriginalExtension();

            // Simpan file ke storage
            $path = $file->storeAs('public/foto_user', $fileName);

            // Simpan path relatif ke database (tanpa "/storage/")
            $relativePath = str_replace('public/', '', $path);

            $user->foto_kanan = $relativePath;
            $user->save();

            return response()->json([
                'success' => true,
                'file_url' => $relativePath,
                'redirect_url' => route('user.produk')
            ]);
        }

        return response()->json(['error' => 'File upload failed'], 422);
    }

    public function profile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->get();

        $foto = Wishlist::where('user_id', Auth::user()->id)->get();

        return view('user.profil', [
            "title" => "Profil Anda",
            "user" => $user,
            "pesanan" => $pesanan,
            "foto" => $foto,
        ]);
    }
}
