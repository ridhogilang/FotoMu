<?php

namespace App\Http\Controllers\Foto;

use App\Models\Earning;
use App\Models\Rekening;
use App\Models\Fotografer;
use App\Models\Withdrawal;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class PembayaranController extends Controller
{
    public function pembayaran()
    {
        $userId = Auth::user()->id;
        $fotografer = Fotografer::where('user_id', $userId)->first();

        $fotograferId = Auth::user()->fotografer->id;

        // Ambil total uang masuk per hari (Pendapatan)
        $uangMasukPerHari = DB::table('earning')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(uang_masuk) as total_uang_masuk'),
                DB::raw('MAX(id) as max_id')  // Ambil id terbesar per hari
            )
            ->where('fotografer_id', $fotograferId)
            ->where('status', 'Pendapatan')
            ->groupBy(DB::raw('DATE(created_at)'))  // Group berdasarkan tanggal saja
            ->get();

        // Ambil saldo akhir berdasarkan id terbesar per hari
        $saldoAkhirPerHari = DB::table('earning')
            ->select('jumlah', DB::raw('DATE(created_at) as date'))
            ->whereIn('id', $uangMasukPerHari->pluck('max_id'))  // Ambil jumlah berdasarkan id terbesar
            ->get()
            ->keyBy('date');  // Mengaitkan saldo akhir dengan tanggal

        // Gabungkan data ke dalam satu hasil
        $uangMasukPerHari->transform(function ($item) use ($saldoAkhirPerHari) {
            $item->saldo_akhir = optional($saldoAkhirPerHari->get($item->date))->jumlah;  // Ambil saldo akhir berdasarkan tanggal
            return $item;
        });

        // Uang keluar dari penarikan yang disetujui
        $uangKeluar = Earning::where('fotografer_id', $fotograferId)
            ->where('status', 'Penarikan')
            ->whereNotNull('uang_keluar')
            ->get();

        $penarikan = Withdrawal::where('fotografer_id', $fotograferId)->get();

        return view('fotografer.pembayaran', [
            "title" => "Pembayaran",
            "fotografer" => $fotografer,
            "uangMasukPerHari" => $uangMasukPerHari,
            "uangKeluar" => $uangKeluar,
            "penarikan" => $penarikan,
        ]);
    }

    public function store_bank(Request $request)
    {
        // Validasi input user
        $request->validate([
            'nama_bank' => 'required',
            'nama' => 'required',
            'rekening' => 'required',
        ]);

        // Generate OTP
        $otp = OTPService::generateOTP();
        $user = Auth::user();

        // Simpan OTP ke session untuk validasi nantinya
        Session::put('otp', $otp);

        // Kirim OTP ke email user
        OTPService::sendOTP($user->email, $otp);

        // Simpan data rekening ke session (sementara, menunggu OTP validasi)
        Session::put('bank_data', $request->all());

        // Kembalikan response JSON sukses
        return response()->json(['message' => 'OTP terkirim, silakan masukkan OTP untuk verifikasi']);
    }

    public function bank_destroy($id)
    {
        // Temukan rekening berdasarkan ID
        $rekening = Rekening::find($id);

        if (!$rekening) {
            return response()->json(['message' => 'Rekening tidak ditemukan.'], 404);
        }

        // Temukan fotografer yang memiliki rekening ini
        $fotografer = Fotografer::where('rekening_id', $rekening->id)->first();

        if ($fotografer) {
            // Set rekening_id menjadi null pada tabel Fotografer
            $fotografer->rekening_id = null;
            $fotografer->save();
        }

        // Hapus rekening dari database
        $rekening->delete();

        return response()->json(['message' => 'Rekening berhasil dihapus dan Fotografer diperbarui.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        // Ambil OTP dari session
        $otp = Session::get('otp');
        Log::info('OTP dari session: ' . $otp);
        Log::info('OTP dari request: ' . $request->otp);

        if ($request->otp == $otp) {
            // OTP valid, simpan rekening ke database
            $data = Session::get('bank_data');
            Log::info('Data rekening: ' . json_encode($data));

            // Simpan atau perbarui rekening
            $rekening = Rekening::create([
                'nama_bank' => $data['nama_bank'],
                'nama' => $data['nama'],
                'rekening' => $data['rekening'],
            ]);

            // Perbarui fotografer dengan rekening_id
            $fotografer = Fotografer::where('user_id', Auth::id())->first();
            if ($fotografer) {
                $fotografer->rekening_id = $rekening->id;
                $fotografer->save();
            }

            // Hapus data dari session
            Session::forget(['otp', 'bank_data']);
            Log::info('OTP dan data rekening dihapus dari session');

            // Kembalikan response JSON sukses
            return response()->json(['message' => 'Rekening berhasil ditambahkan dan diverifikasi!']);
        } else {
            Log::warning('Kode OTP salah');
            return response()->json(['error' => 'Kode OTP salah'], 422);
        }
    }
    public function resendOtp()
    {
        // Dapatkan user yang sedang login
        $user = Auth::user();

        // Generate OTP baru
        $otp = OTPService::generateOTP();

        // Simpan OTP baru ke session untuk validasi ulang nantinya
        Session::put('otp', $otp);

        // Kirim ulang OTP ke email user
        OTPService::sendOTP($user->email, $otp);

        // Kembalikan response JSON sukses
        return response()->json(['message' => 'OTP baru telah dikirim ke email Anda']);
    }

    public function cekRekeningFotografer()
    {
        // Misalnya, dapatkan ID fotografer yang sedang login
        $fotograferId = Auth::user()->fotografer->id;

        // Cek apakah rekening_id ada untuk fotografer ini
        $fotografer = Fotografer::find($fotograferId);

        if ($fotografer && $fotografer->rekening_id) {
            return response()->json(['rekening_ada' => true]);
        } else {
            return response()->json(['rekening_ada' => false]);
        }
    }

    public function withdrawal_store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'rekening_id' => 'required|exists:rekening,id',  // pastikan rekening_id ada di tabel rekening
        ]);

        // Dapatkan ID fotografer yang sedang login
        $fotograferId = Auth::user()->fotografer->id;

        // Ambil saldo terbaru dari tabel 'earning'
        $saldo = Earning::where('fotografer_id', $fotograferId)
            ->where('status', 'Pendapatan')
            ->orderBy('created_at', 'desc')  // Dapatkan record terbaru
            ->orderBy('id', 'desc')          // Dapatkan id terbesar untuk menghindari konflik
            ->value('jumlah');               // Ambil saldo

        // Validasi jumlah penarikan tidak lebih dari saldo
        if ($request->jumlah > $saldo) {
            return redirect()->back()->with('toast_error', 'Jumlah penarikan tidak boleh lebih besar dari saldo yang tersedia.');
        }

        // Simpan data penarikan ke dalam tabel 'withdrawal'
        Withdrawal::create([
            'fotografer_id' => $fotograferId,
            'rekening_id' => $request->rekening_id,
            'jumlah' => $request->jumlah,
            'saldo' => $saldo,
            'status' => 'Pending',
            'requested_at' => now(),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Penarikan berhasil diajukan. Menunggu persetujuan.');
    }

    public function withdrawal_destroy($id)
    {
        // Cari record withdrawal berdasarkan id
        $withdrawal = Withdrawal::find($id);

        // Jika withdrawal ditemukan, hapus record tersebut
        if ($withdrawal) {
            $withdrawal->delete();
            return response()->json(['success' => 'Data berhasil dihapus!']);
        }

        // Jika withdrawal tidak ditemukan, kirimkan respon gagal
        return response()->json(['error' => 'Data tidak ditemukan!'], 404);
    }
}