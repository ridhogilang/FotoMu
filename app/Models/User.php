<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // Import trait HasRoles


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto_depan',
        'foto_kanan',
        'is_admin',
        'is_foto',
        'is_user',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function foto()
    {
        return $this->hasMany(Foto::class, 'user_id');
    }

    public function similarFoto()
    {
        return $this->hasMany(SimilarFoto::class, 'user_id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function fotografer()
    {
        return $this->hasOne(Fotografer::class, 'user_id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'foto_id');
    }

    public function pesananSelesai()
    {
        return $this->hasManyThrough(
            Pesanan::class, // Model tujuan
            DetailPesanan::class, // Model perantara
            'user_id', // Foreign key pada `DetailPesanan`
            'id', // Foreign key pada `Pesanan`
            'id', // Primary key pada `User`
            'pesanan_id' // Foreign key pada `DetailPesanan`
        )->where('status', 'Selesai'); // Hanya pesanan dengan status 'Selesai'
    }
}
