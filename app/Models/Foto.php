<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';

    protected $fillable = [
        'user_id',
        'event_id',
        'foto',
        'fotowatermark',
        'harga',
        'deskripsi',
        'file_size',
        'resolusi',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function similarFoto()
    {
        return $this->hasMany(SimilarFoto::class, 'foto_id');
    }

    public function detailPesanan()
    {
      return $this->hasMany(DetailPesanan::class, 'foto_id');
    }
}
