<?php

namespace App\Services;

use App\Mail\SendOTP;
use Illuminate\Support\Facades\Mail;

class OTPService
{
    public static function generateOTP($length = 6)
    {
        return random_int(100000, 999999);
    }

    public static function sendOTP($email, $otp)
    {
        $details = [
            'title' => 'Kode OTP untuk Verifikasi Penambahan Rekening',
            'otp' => $otp
        ];

        // Mengirim email OTP
        Mail::to($email)->send(new SendOTP($details));
    }
}
