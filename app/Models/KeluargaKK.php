<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeluargaKK extends Model
{
    protected $table = 'keluarga_kk';
    protected $primaryKey = 'kk_id';

    protected $fillable = [
        'kk_nomor',
        'kepala_keluarga_warga_id',
        'alamat',
        'rt',
        'rw',
    ];

    public function anggota()
    {
        return $this->hasMany(AnggotaKeluarga::class, 'kk_id');
    }

    public function kepala()
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_warga_id', 'warga_id');
    }
}
