<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Fotografer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\VerifyMail as VerifyMailModel;



class VerificationController extends Controller
{
    public function verifyEmail($id)
    {
        // Cari verifikasi email berdasarkan ID
        $verimail = VerifyMailModel::where('id', $id)->first();

        if (!$verimail) {
            return redirect()->route('login')->with('toast_error', 'Invalid verification link.');
        }

        // Verifikasi pengguna berdasarkan email
        $user = User::where('email', $verimail->email)->first();

        if ($user) {
            // Tandai email sebagai terverifikasi
            $user->email_verified_at = now();
            $user->save();

            // Hapus data verifikasi setelah berhasil
            $verimail->delete();
            Auth::login($user);

            if ($user->is_admin) {
                return redirect()->route('admin.dashboard')->with('success', 'Halo selamat datang ' . $user->name);
            } elseif ($user->is_foto) {
                $fotografer = Fotografer::where('user_id', $user->id)->first();

                if (is_null($fotografer)) {
                    return redirect()->route('foto.upload')->with('warning', 'Silakan lengkapi data fotografer Anda.');
                } else {
                    return redirect()->route('foto.profil')->with('success', 'Halo selamat datang ' . $user->name);
                }
            } elseif ($user->is_user) {
                if (is_null($user->foto_depan)) {
                    return redirect()->route('user.formfotodepan')->with('warning', 'Silakan lengkapi foto depan Anda.');
                } else {
                    return redirect()->route('user.produk')->with('success', 'Halo selamat datang ' . $user->name);
                }
            }
        }

        return redirect()->route('login')->with('toast_error', 'User not found.');
    }
}
