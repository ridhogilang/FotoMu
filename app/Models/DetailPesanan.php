<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    protected $fillable = [
        'user_id',
        'pesanan_id',
        'foto_id',
        'foto',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    public function foto()
    {
        return $this->belongsTo(Foto::class, 'foto_id');
    }

    public function earning()
    {
        return $this->hasOne(Earning::class, 'detail_pesanan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
