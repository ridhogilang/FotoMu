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
        'harga',
        'deskripsi',
        'file_size',
        'resolusi',
    ];
}
