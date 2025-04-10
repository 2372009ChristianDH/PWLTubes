<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';
    protected $primaryKey = 'id';
    protected $fillable = ['id','nama_program_studi'];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'id_program_studi', 'id');
    }
}
