<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratDetail extends Model
{
    protected $table = 'surat_detail';

    protected $fillable = [
        'id_surat',
        'id_users',
        'jenis_surat',
        'tgl_permohonan',
        'status_persetujuan',
        'keterangan',
        'tgl_persetujuan',
    ];

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
