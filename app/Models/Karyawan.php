<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';

    protected $primaryKey = 'id';
    protected $fillable = ['nik', 'id_program_studi', 'id_users', 'status_karyawan', 'tahun_mulai', 'tahun_selesai'];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', 'id');
        
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_program_studi', 'id');
    }

}
