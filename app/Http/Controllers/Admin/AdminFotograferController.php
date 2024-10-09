<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DaftarFotografer;
use App\Models\Fotografer;

class AdminFotograferController extends Controller
{
    public function pendaftaran_fotografer()
    {
        $daftar = DaftarFotografer::where('is_validate', false)->get();
        return view('admin.pendaftaran_fotografer', [
            "title" => "Pendaftaran Fotografer",
            "daftar" => $daftar,
        ]);
    }

    public function fotografer()
    {
        $fotografer = Fotografer::with('user')->get();
        
        return view('admin.fotografer', [
            "title" => "Fotografer",
            "fotografer" => $fotografer,
        ]);
    }
}
