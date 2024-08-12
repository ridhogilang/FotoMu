<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProdukController extends Controller
{
    public function produk()
    {
        return view('user.produk',[
            "title" => "Foto Anda"
        ]);
    }
}
