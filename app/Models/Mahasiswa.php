<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nrp', 'id_users', 'id_program_studi'];
    protected $keyType = 'int';
    

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_program_studi');
    }
}
