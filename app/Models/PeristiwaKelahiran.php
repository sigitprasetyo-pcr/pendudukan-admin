<?php
namespace App\Models;

// [PERBAIKAN 1]: Hapus import diri sendiri
// use App\Models\PeristiwaKelahiran;

// [PERBAIKAN 2]: Import Model Warga untuk definisi relasi
use App\Models\Warga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PeristiwaKelahiran extends Model
{
    // [PERBAIKAN 3]: Ganti nama tabel ke 'peristiwa_kelahiran' agar sesuai skema database
    protected $table      = 'peristiwa_kelahiran';
    protected $primaryKey = 'kelahiran_id';
    public $timestamps    = true;

    protected $fillable = [
        'warga_id', // Bayi
        'tgl_lahir',
        'tempat_lahir',
        'ayah_warga_id',
        'ibu_warga_id',
        'no_akta',
    ];

    /**
     * Relasi ke warga (bayi yang lahir - FK: warga_id)
     */
    public function bayi()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
    }

    /**
     * Relasi ke warga (ayah - FK: ayah_warga_id)
     */
    public function ayah()
    {
        return $this->belongsTo(Warga::class, 'ayah_warga_id', 'warga_id');
    }

    /**
     * Relasi ke warga (ibu - FK: ibu_warga_id)
     */
    public function ibu()
    {
        return $this->belongsTo(Warga::class, 'ibu_warga_id', 'warga_id');
    }
    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }
        return $query;
    }

    public function scopeSearch(Builder $query, $request, array $columns): Builder
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', '%' . $request->search . '%');
                }
            });
        }
        return $query;
    }
}
