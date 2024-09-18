<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $table = 'earning';

    protected $fillable = [
        'fotografer_id',
        'detail_pesanan_id',
        'uang_masuk',
        'uang_keluar',
        'jumlah',
        'status',
    ];

    public function fotografer()
    {
        return $this->belongsTo(Fotografer::class, 'fotografer_id');
    }

    public function detailPesanan()
    {
        return $this->belongsTo(DetailPesanan::class, 'detail_pesanan_id');
    }

}
