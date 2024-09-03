<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotografer extends Model
{
    use HasFactory;

    protected $table = 'fotografer';

    protected $fillable = [
        'user_id',
        'rekening_id',
        'nama',
        'alamat',
        'nowa',
        'foto_ktp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function foto()
    {
        return $this->hasMany(User::class, 'fotografer_id');
    }
}
