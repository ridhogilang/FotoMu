<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
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
}
