<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public static function isUserRegistered($userId = null)
    {
        $userId = $userId ?? Auth::id();
        return self::where('user_id', $userId)->exists();
    }

}
