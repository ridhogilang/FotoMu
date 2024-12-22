<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\DetailPesanan;
use App\Http\Controllers\Controller;
use App\Models\DaftarFotografer;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        $userId = Auth::id();
        $fotoId = $request->query('foto_id');

        if ($fotoId) {
            // If a specific foto_id is passed, only show that item in the cart
            $cart = Cart::where('user_id', $userId)->where('foto_id', $fotoId)->get();
        } else {
            // Otherwise, show all items in the cart
            $cart = Cart::where('user_id', $userId)->get();
        }

        $total = 0;
        foreach ($cart as $cartItem) {
            $total += $cartItem->foto->harga;
        }

        $adminFee = 2000;
        $taxRate = 0.11; // 11%
        $tax = $total * $taxRate;
        $totalPayment = $total + $adminFee + $tax;

        return view('user.cart', [
            "title" => "Keranjang Anda",
            "cart" => $cart,
            'total' => $total,
            'adminFee' => $adminFee,
            'tax' => $tax,
            'totalPayment' => $totalPayment
        ]);
    }


    public function toggleWishlist(Request $request)
    {
        $userId = Auth::id();
        $fotoId = $request->foto_id;

        $existingWishlist = Wishlist::where('user_id', $userId)->where('foto_id', $fotoId)->first();

        if ($existingWishlist) {
            $existingWishlist->delete();
            return response()->json(['success' => 'Foto berhasil dihapus dari wishlist!', 'added' => false]);
        } else {
            $wishlist = new Wishlist();
            $wishlist->user_id = $userId;
            $wishlist->foto_id = $fotoId;
            $wishlist->save();
            return response()->json(['success' => 'Foto berhasil ditambahkan ke wishlist!', 'added' => true]);
        }
    }

    public function toggleCart(Request $request)
    {
        // Validasi request
        $request->validate([
            'foto_id' => 'required', // Pastikan 'fotos' adalah nama tabel yang benar
        ]);

        // Get the current user's ID
        $userId = Auth::id();

        // Periksa apakah foto_id sudah ada di model detail pesanan terkait dengan pesanan user yang sedang login
        $existsInPesanan = DetailPesanan::whereHas('pesanan', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'Selesai');
        })->where('foto_id', $request->foto_id)->exists();
        
        if ($existsInPesanan) {
            return response()->json(['status' => 'error', 'error' => 'Foto ini sudah ada di dalam pesanan Anda sebelumnya!'], 422);
        }

        // Periksa apakah item sudah ada di cart
        $existingCart = Cart::where('user_id', Auth::id())->where('foto_id', $request->foto_id)->first();

        if ($existingCart) {
            // Hapus item dari cart jika sudah ada
            $existingCart->delete();
            return response()->json(['status' => 'removed', 'success' => 'Foto dihapus dari cart!']);
        } else {
            // Tambahkan item ke cart jika belum ada
            $cart = new Cart();
            $cart->user_id = Auth::id(); // Mengambil ID user yang sedang login
            $cart->foto_id = $request->foto_id;
            $cart->save();

            return response()->json(['status' => 'added', 'success' => 'Foto berhasil ditambahkan ke cart!']);
        }
    }

    public function hapusCart($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return response()->json(['success' => 'Item removed from cart']);
    }

    public function buyNow(Request $request)
    {
        // Validate the request
        $request->validate([
            'foto_id' => 'required|exists:foto,id', // Ensure the foto_id exists in the fotos table
        ]);

        $userId = Auth::id();

        $existsInPesanan = DetailPesanan::whereHas('pesanan', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'Selesai');
        })->where('foto_id', $request->foto_id)->exists();        

        if ($existsInPesanan) {
            // If the foto is already in a previous order, return with an error message
            return redirect()->back()->with('toast_error', 'Foto ini sudah ada di dalam pesanan Anda sebelumnya!');
        }

        // Check if the item already exists in the cart
        $existingCart = Cart::where('user_id', $userId)->where('foto_id', $request->foto_id)->first();

        if (!$existingCart) {
            // If the item is not in the cart, add it
            Cart::create([
                'user_id' => $userId,
                'foto_id' => $request->foto_id,
            ]);
        }

        // Redirect to the cart page with the specific foto_id
        return redirect()->route('user.cart', ['foto_id' => $request->foto_id])->with('success', 'Foto berhasil ditambahkan ke cart!');
    }

    public function wishlist()
    {
        $user = Auth::user();

        $wishlist = Wishlist::where('user_id',  $user->id)->pluck('foto_id')->toArray();
        $wishlistAll = Wishlist::where('user_id',  $user->id)->paginate(8, ['*'], 'semua_page');

        $cartItemIds = Cart::where('user_id', Auth::id())->pluck('foto_id')->toArray();

        return view('user.wishlist', [
            "title" => "Wishlist FotoMu",
            "semuaFoto" => $wishlistAll,
            "wishlist" => $wishlist,
            "cartItemIds" => $cartItemIds,
        ]);
    }
}
