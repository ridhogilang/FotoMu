<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $table = 'withdrawal';

    protected $fillable = [
        'fotografer_id',
        'rekening_id',
        'jumlah',
        'saldo',
        'status',
        'requested_at',
        'processed_at',
    ];

    public function fotografer()
    {
        return $this->belongsTo(User::class, 'fotografer_id');
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }

}
