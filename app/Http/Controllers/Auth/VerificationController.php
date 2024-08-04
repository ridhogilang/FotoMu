<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

            return redirect()->route('admin.dashboard')->with('success', 'Email successfully verified!');
        }

        return redirect()->route('login')->with('toast_error', 'User not found.');
    }
}
