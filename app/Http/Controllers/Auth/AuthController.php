<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\VerifyMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\VerifyMail as VerifyMailModel;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            "title" => "Halaman Login"
        ]);
    }

    public function daftar()
    {
        return view('auth.daftar', [
            "title" => "Halaman Registrasi"
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
                Auth::logout();
                return redirect()->back()->with('toast_error', 'Silahkan verifikasi akun via email.');
            }

            return redirect()->route('admin.dashboard')->with('success', 'Halo selamat datang ' . $user->name);
        }

        return redirect()->back()->with('toast_error', 'Invalid email or password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            // Collect error messages as a single string
            $errors = implode('<br>', $validator->errors()->all());

            return redirect()->back()
                ->with('toast_error', $errors) // Set errors in session as toast_error
                ->withInput();
        }

        // Ambil semua input yang valid
        $input = $request->all();

        // Membuat user baru
        $user = User::create([
            'name' => $input['fullname'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
        ]);

        // Verifikasi email
        $verimail = [
            'id' => date('Ymdhis') . '-' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 75),
            'email' => $input['email'],
            'id_user' => $user->id
        ];

        VerifyMailModel::create($verimail);

        // Kirim email verifikasi
        Mail::to($verimail['email'])->send(new VerifyMail($verimail));

        // Login user baru (opsional)
        Auth::login($user);

        $confirmationMessage = 'A email has been sent to <b>' . $input['email'] . '</b>. Please check for an email from the company and click on the included link to reset your password.';

        return redirect()->route('konfirmasi-akun')->with('confirmationMessage', $confirmationMessage);
    }

    public function konfirmasiakun()
    {
        // Cek apakah ada pesan konfirmasi di session
        if (!session()->has('confirmationMessage')) {
            return redirect()->route('daftar'); // Atau rute lain yang sesuai
        }

        return view('auth.konfirmasiakun', [
            "title" => "Konfirmasi Akun"
        ]);
    }

    public function showLinkRequestForm()
    {
        return view('auth.lupapassword', [
            "title" => "Lupa Password"
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('toast_error', 'Email tidak terdaftar.');
        }

        // Generate token reset password
        $token = app('auth.password.broker')->createToken($user);

        // Data yang akan dikirim ke email
        $data = [
            'email' => $request->email,
            'token' => $token
        ];

        // Kirim email menggunakan template kustom
        Mail::to($request->email)->send(new ResetPasswordMail($data));

        // Tampilkan pesan sukses
        $confirmationMessage = 'A email has been sent to <b>' . $request->email . '</b>. Please check for an email from the company and click on the included link to reset your password.';

        return redirect()->route('konfirmasi-akun')->with('confirmationMessage', $confirmationMessage);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], []);

        // Melakukan reset password
        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Mengubah password dan login user
                $user->password = bcrypt($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                auth()->login($user);
            }
        );

        // Mengirim respons sesuai dengan hasil reset password
        if ($response == Password::PASSWORD_RESET) {
            return redirect('/')->with('success', trans($response));
        } else {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
        }
    }
}
