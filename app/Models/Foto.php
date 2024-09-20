<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'foto';

    protected $fillable = [
        'fotografer_id',
        'event_id',
        'foto',
        'fotowatermark',
        'harga',
        'deskripsi',
        'file_size',
        'resolusi',
        'is_hapus',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function fotografer()
    {
        return $this->belongsTo(Fotografer::class, 'fotografer_id');
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
