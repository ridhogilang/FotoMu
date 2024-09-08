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

        $earnings = Earning::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(jumlah) as total_earning')
        )
            ->where('fotografer_id', $fotografer->id)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Ambil data withdrawal per ID
        $withdrawals = Withdrawal::select(
            'id',
            'jumlah',
            'requested_at',
            'status'
        )
            ->where('fotografer_id', $fotografer->id)
            ->get();

        // Gabungkan data earning dan withdrawal dalam satu array
        $pendapatan = [];

        // Earning diakumulasi per hari
        foreach ($earnings as $earning) {
            $pendapatan[$earning->date]['earning'] = $earning->total_earning;
            $pendapatan[$earning->date]['withdrawals'] = []; // Set empty withdrawals
        }

        // Withdrawal ditampilkan per ID
        foreach ($withdrawals as $withdrawal) {
            $date = $withdrawal->requested_at->format('Y-m-d');
            if (isset($pendapatan[$date])) {
                $pendapatan[$date]['withdrawals'][] = [
                    'id' => $withdrawal->id,
                    'jumlah' => $withdrawal->jumlah,
                    'status' => $withdrawal->status
                ];
            } else {
                // Jika tidak ada earning pada hari tersebut, tambahkan tanggal baru
                $pendapatan[$date]['earning'] = 0; // Set earning ke 0 jika tidak ada
                $pendapatan[$date]['withdrawals'][] = [
                    'id' => $withdrawal->id,
                    'jumlah' => $withdrawal->jumlah,
                    'status' => $withdrawal->status
                ];
            }
        }

        ksort($pendapatan);

        return view('fotografer.pembayaran', [
            "title" => "Pembayaran",
            "fotografer" => $fotografer,
            "pendapatan" => $pendapatan,
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
}
