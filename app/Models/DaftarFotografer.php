<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarFotografer extends Model
{
    use HasFactory;

    protected $table = 'daftar_fotografer';

    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'nowa',
        'foto_ktp',
        'pesan',
        'status',
        'is_validate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
