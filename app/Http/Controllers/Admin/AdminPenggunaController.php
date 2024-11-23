<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\VerifyMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\VerifyMail as VerifyMailModel;


class AdminPenggunaController extends Controller
{
    public function pengguna()
    {
        $user = User::all();

        return view('admin.daftar_user', [
            "title" => "Daftar User",
            "user" => $user,
        ]);
    }

    public function updateStatusActive(Request $request, $id)
    {
        // Validasi ID pengguna
        $user = User::findOrFail($id);

        // Periksa apakah checkbox dikirimkan dan dicentang
        $isActive = $request->boolean('is_active'); // Mengembalikan true jika checked, false jika unchecked

        // Update kolom is_active
        $user->update(['is_active' => $isActive]);

        return response()->json([
            'success' => true,
            'message' => 'Status aktif berhasil diperbarui.',
            'is_active' => $isActive
        ]);
    }

    public function tambah()
    {
        return view('admin.tambah_admin', [
            "title" => "Tambah User",
        ]);
    }

    public function store_user(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nowa' => 'required|digits_between:10,15', // Pastikan nomor sesuai panjang valid
            'password' => 'required|string|min:8|confirmed', // 'confirmed' memastikan cocok dengan confirmPassword
            'role' => 'required|in:Admin,Fotografer,User', // Validasi role yang valid
        ]);

        // Buat data pengguna baru
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = Hash::make($validatedData['password']); // Enkripsi password
        $user->nowa = $validatedData['nowa']; // Nomor WhatsApp
        $user->is_admin = 0;
        $user->is_foto = 0;
        $user->is_user = 0;

        // Tentukan role
        switch ($validatedData['role']) {
            case 'Admin':
                $user->is_admin = 1;
                $user->save();
                $user->assignRole('admin'); // Assign role 'admin'
                break;

            case 'Fotografer':
                $user->is_foto = 1;
                $user->save();
                $user->assignRole('foto'); // Assign role 'foto'
                break;

            case 'User':
                $user->is_user = 1;
                $user->save();
                $user->assignRole('user'); // Assign role 'user'
                break;

            default:
                return response()->json(['error' => 'Role tidak valid'], 400);
        }

        // Tambahkan data ke tabel verifikasi email
        $verimail = [
            'id' => date('Ymdhis') . '-' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 75),
            'email' => $validatedData['email'],
            'id_user' => $user->id
        ];

        VerifyMailModel::create($verimail);

        // Kirim email verifikasi
        Mail::to($verimail['email'])->send(new VerifyMail($verimail));

        // Redirect atau kirim response sukses
        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan. Email verifikasi telah dikirim.');
    }
}
