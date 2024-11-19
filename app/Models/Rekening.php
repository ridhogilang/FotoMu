<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekening';

    protected $fillable = [
        'nama',
        'rekening',
        'nama_bank',
    ];

    public function withdrawal()
    {
        return $this->hasMany(Withdrawal::class, 'rekening_id');
    }

    public function fotografer()
    {
        return $this->hasOne(Fotografer::class, 'rekening_id', 'id');
    }
}
