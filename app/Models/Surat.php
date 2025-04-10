<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';

    protected $primaryKey = 'id';
    protected $fillable = ['id', 'jenis_surat', 'nama', 'periode', 'alamat', 'keperluan_pembuatan', 'tujuan_surat', 'nama_mk', 'topik', 'tujuan_topik', 'tgl_kelulusan'];


    public function suratDetail()
    {
        return $this->hasOne(SuratDetail::class, 'id_surat', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
    

}
