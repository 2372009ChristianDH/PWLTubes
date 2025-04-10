<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';  // Gunakan tabel 'user' untuk menyimpan password

    protected $fillable = [
        'nama',
        'email',
        'password',
        'id_roles',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id_users');  // Relasi ke tabel mahasiswa
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'id_roles');
    }


}
