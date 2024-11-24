<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\VerifyMail;
use App\Models\Fotografer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Cek kredensial
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Cek apakah email sudah diverifikasi
            if (is_null($user->email_verified_at)) {
                Auth::logout();
                return redirect()->back()->with('toast_error', 'Silahkan verifikasi akun via email.');
            }

            // Logika redirect berdasarkan tipe user
            if ($user->is_admin) {
                // Redirect ke admin dashboard jika is_admin true
                return redirect()->route('admin.dashboard')->with('success', 'Halo selamat datang ' . $user->name);
            } elseif ($user->is_foto) {
                // Jika is_foto true, cek apakah user_id sudah ada di tabel fotografer
                $fotografer = Fotografer::where('user_id', $user->id)->first();

                if (is_null($fotografer)) {
                    return redirect()->route('foto.upload')->with('warning', 'Silakan lengkapi data fotografer Anda.');
                } else {
                    return redirect()->route('foto.profil')->with('success', 'Halo selamat datang ' . $user->name);
                }
            } elseif ($user->is_user) {
                // Jika is_user true, cek foto_depan
                if (is_null($user->foto_depan)) {
                    return redirect()->route('user.formfotodepan')->with('warning', 'Silakan lengkapi foto depan Anda.');
                } else {
                    return redirect()->route('user.produk')->with('success', 'Halo selamat datang ' . $user->name);
                }
            }

            // Default jika tipe user tidak dikenali
            return redirect()->back()->with('toast_error', 'Tipe pengguna tidak dikenali.');
        }

        // Jika login gagal
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

    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Cek apakah password lama yang dimasukkan cocok
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('toast_error', 'Password lama salah');
        }

        // Update password user dengan password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Password berhasil diperbarui');
    }
}
