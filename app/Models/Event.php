<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'event',
        'lokasi',
        'tanggal',
        'is_private',
        'password',
        'deskripsi',
    ];

    public function foto()
    {
        return $this->hasMany(Foto::class, 'event_id');
    }
}
