<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeluargaKk extends Model
{
    protected $table      = 'keluarga_kk';
    protected $primaryKey = 'kk_id';
    public $timestamps    = true;

    protected $fillable = [
        'kk_nomor',
        'kepala_keluarga_warga_id',
        'alamat',
        'rt',
        'rw',
    ];

    /**
     * Relasi dengan Warga (kepala keluarga)
     */
    public function kepalaKeluarga()
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_warga_id', 'warga_id');
    }
}
