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
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class PemesananController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pesanan = Pesanan::where('user_id', $user->id)
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal pembuatan secara descending (terbaru di atas)
            ->get();

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
        $fotograferId = Foto::find($detailPesanan->first()->foto_id)->fotografer_id;

        $lastEarning = Earning::where('fotografer_id', $fotograferId)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        if ($detailPesanan->isNotEmpty()) {
            $fotograferId = Foto::find($detailPesanan->first()->foto_id)->fotografer_id;

            $jumlahAkhir = $lastEarning ? $lastEarning->jumlah : 0;

            foreach ($detailPesanan as $item) {
                $foto = Foto::find($item->foto_id);
                $jumlahEarning = $foto->harga * 0.9;  // 90% dari harga foto untuk fotografer
                $jumlahAkhir += $jumlahEarning;

                Earning::create([
                    'fotografer_id'      => $foto->fotografer_id,   // Fotografer yang mengupload foto
                    'detail_pesanan_id'  => $item->id,              // Detail pesanan terkait
                    'uang_masuk'         => $jumlahEarning,         // 90% dari harga foto
                    'jumlah'             => $jumlahAkhir,           // Jumlah akhir yang diperbarui
                    'status'             => "Pendapatan"            // Status pendapatan
                ]);
            }


            // Membuat ZIP secara langsung dalam memori
            $zip = new \ZipArchive();
            $zipFileName = 'pesanan_' . $pesanan->id . '.zip';

            // Buat file ZIP dalam memori (output buffer)
            $tempZip = tempnam(sys_get_temp_dir(), $zipFileName);
            if ($zip->open($tempZip, \ZipArchive::CREATE) === TRUE) {
                foreach ($detailPesanan as $item) {
                    $filePath = Storage::path('public/' . Foto::find($item->foto_id)->foto);
                    $zip->addFile($filePath, basename($filePath)); // Tambahkan file ke dalam zip
                }
                $zip->close();
            }

            // Mengirim file ZIP sebagai respons download
            return response()->download($tempZip, $zipFileName)->deleteFileAfterSend(true);
        } 

        return redirect()->route('user.pesanan')->with('success', 'Pesanan anda sudah selesai. Foto sudah disalin ke folder baru.');
    }

    public function download()
    {
        $user = Auth::user();

        $pesanan = DetailPesanan::with(['pesanan', 'user', 'foto']) // Sesuaikan dengan relasi yang ada
        ->where('user_id', $user->id) // Filter berdasarkan id user
        ->whereHas('pesanan', function ($query) {
            // Filter berdasarkan status pesanan yang 'Selesai'
            $query->where('status', 'Selesai');
        })
        ->get()
        ->groupBy(function ($item) {
            // Kelompokkan berdasarkan tanggal (format hari/bulan/tahun)
            return Carbon::parse($item->created_at)->format('d F Y');
        })
        ->sortByDesc(function ($items, $tanggal) {
            // Urutkan tanggal secara descending
            return Carbon::createFromFormat('d F Y', $tanggal)->timestamp;
        });    

        return view('user.download', [
            "title" => "Download FotoMu",
            "pesanan" => $pesanan,
        ]);
    }

    public function cancelOrder($id)
    {
        try {
            // Temukan pesanan berdasarkan ID
            $order = Pesanan::findOrFail($id);

            // Ubah status menjadi dibatalkan
            $order->status = 'Dibatalkan';
            $order->is_selesai = true;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}
