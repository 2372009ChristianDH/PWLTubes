<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $primaryKey = 'id';
    protected $fillable = ['id,nik', 'nama', 'email', 'password', 'tgl_lahir', 'role'];
    protected $keyType = 'string';
    public $incrementing = false;
}
