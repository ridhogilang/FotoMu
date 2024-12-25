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

            if ($user->is_active === 0) {
                Auth::logout();
                return redirect()->back()->with('toast_error', 'Akun anda sedang dibekukan, silahkan hubungi admin');
            }            

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

            return redirect()->back()->with('toast_error', 'Tipe pengguna tidak dikenali.');
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
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = implode('<br>', $validator->errors()->all());

            return redirect()->back()
                ->with('toast_error', $errors)
                ->withInput();
        }

        $input = $request->all();
        $user = User::create([
            'name' => $input['fullname'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
        ]);

        $user->assignRole('user');
        $user->is_user = 1;
        $user->save();

        $verimail = [
            'id' => date('Ymdhis') . '-' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 75),
            'email' => $input['email'],
            'id_user' => $user->id
        ];

        VerifyMailModel::create($verimail);
        Mail::to($verimail['email'])->send(new VerifyMail($verimail));
        Auth::logout();

        $confirmationMessage = 'Email verifikasi telah dikirim ke <b>' . $input['email'] . '</b>. Silakan cek email Anda dan klik tautan untuk memverifikasi akun Anda.';

        return redirect()->route('konfirmasi-akun')->with('confirmationMessage', $confirmationMessage);
    }

    public function konfirmasiakun()
    {
        if (!session()->has('confirmationMessage')) {
            return redirect()->route('daftar');
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

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('toast_error', 'Email tidak terdaftar.');
        }

        $token = app('auth.password.broker')->createToken($user);
        $data = [
            'email' => $request->email,
            'token' => $token
        ];

        Mail::to($request->email)->send(new ResetPasswordMail($data));

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], []);

        $response = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                auth()->login($user);
            }
        );

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
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('toast_error', 'Password lama salah');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui');
    }
}
