<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Foto;
use App\Models\Earning;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Support\Carbon;
use App\Jobs\SendWatzapMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PemesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('user_id', $user->id)->get();

        return view('user.pesanan', [
            "title" => "Orderan Anda",
            "pesanan" => $pesanan,
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'totalharga' => 'required',
            'catatan' => 'max:255',
        ]);

        $status = 'Menunggu Pembayaran';

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Parameter Midtrans untuk pembayaran
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $request->totalharga,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $validatedData['snap_token'] = $snapToken;
        $validatedData['status'] = $status;

        // Buat pesanan
        $pesanan = Pesanan::create($validatedData);

        // Dapatkan array `foto_ids` dari request dan buat detail pesanan untuk setiap item
        $params1 = [];
        foreach ($request->foto_ids as $foto_id) {
            $params1[] = [
                'user_id' => $request->user_id,
                'pesanan_id' => $pesanan->id,
                'foto_id' => $foto_id,
                'created_at' => Carbon::now(),
            ];
        }

        // Masukkan semua detail pesanan ke dalam tabel `detail_pesanan`
        DetailPesanan::insert($params1);

        // Hapus semua item dari cart berdasarkan foto_ids
        Cart::where('user_id', $validatedData['user_id'])->whereIn('foto_id', $request->foto_ids)->delete();

        // Redirect ke halaman invoice
        $encryptedId = Crypt::encryptString($pesanan->id);
        return redirect()->route('user.invoice', ['id' => $encryptedId])
            ->with('success', 'Silahkan lanjutkan ke proses pembayaran');
    }


    public function invoice($id)
    {
        $encryptId = Crypt::decryptString($id);

        $pesanan = Pesanan::where('id', $encryptId)->first();
        $foto = DetailPesanan::where('pesanan_id', $encryptId)->get();

        $total = 0;
        foreach ($foto as $cartItem) {
            $total += $cartItem->foto->harga;
        }

        $adminFee = 2000;
        $taxRate = 0.11; // 11%
        $tax = $total * $taxRate;
        $totalPayment = $total + $adminFee + $tax;

        return view('user.invoice', [
            "title" => "Invoice",
            "pesanan" => $pesanan,
            "foto" => $foto,
            'total' => $total,
            'adminFee' => $adminFee,
            'tax' => $tax,
            'totalPayment' => $totalPayment
        ]);
    }

    public function success($id)
    {
        $pesanan = Pesanan::where('id', $id)->first();
        $pesanan->status = 'Selesai';
        $pesanan->save();

        $detailPesanan = DetailPesanan::where('pesanan_id', $pesanan->id)->get();

        foreach ($detailPesanan as $item) {
            $foto = Foto::find($item->foto_id);
            $jumlahEarning = $foto->harga * 0.9;

            Earning::create([
                'fotografer_id'      => $foto->fotografer_id,   // Fotografer yang mengupload foto
                'detail_pesanan_id'  => $item->id,              // Detail pesanan terkait
                'jumlah'             => $jumlahEarning,         // 90% dari harga foto
            ]);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('user.pesanan')->with('success', 'Pesanan anda sudah masuk dan akan segera di Proses. Pesan notifikasi sedang dikirim.');
    }
}
