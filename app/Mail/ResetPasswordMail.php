<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($resetData)
    {
        $this->data = $resetData;
    }

    public function build()
    {
        $this->data['judul'] = 'Reset Password Anda';
        $this->data['kata-kata'] = 'Kami menerima permintaan untuk mereset password Anda. Klik tautan di bawah ini untuk mereset password Anda:';
        $this->data['tautan'] = url('/password/reset/'.$this->data['token'].'?email='.$this->data['email']);
        $this->data['tombol'] = 'Reset Password';
        $this->data['kata-penutup'] = 'Jika Anda tidak meminta reset password, Anda dapat mengabaikan pesan ini.';
        
        return $this->view('auth.mail.password')
                    ->with('data', $this->data)
                    ->subject('Reset Password');
    }
}
