<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PemesananController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'totalharga' => 'required',
            'catatan' => 'max:255',
        ]);

        $status = 'Menunggu Pembayaran';

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $request->totalharga,
            ),
            'costumer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $validatedData['snap_token'] = $snapToken;
        $validatedData['status'] = $status;

        $pesanan = Pesanan::create($validatedData);

        $cart = Cart::where('user_id', $validatedData['user_id'])->get();
        $params1 = array();
        foreach ($cart as $cartItem) {
            $params1[] = array(
                'pesanan_id' => $pesanan->id,
                'foto_id' => $cartItem->foto_id,
                'created_at' => Carbon::now(),
            );
        }

        DetailPesanan::insert($params1);
        Cart::where('user_id', $validatedData['user_id'])->delete();

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
}
