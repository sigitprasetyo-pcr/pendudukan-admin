<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class AnggotaKeluarga extends Model
{
    protected $table = 'anggota_keluarga';
    protected $primaryKey = 'anggota_id';

    protected $fillable = [
        'kk_id',
        'warga_id',
        'hubungan',
    ];

    public function kk()
    {
        return $this->belongsTo(KeluargaKK::class, 'kk_id', 'kk_id');
    }

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'warga_id', 'warga_id');
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
        $query->where(function($q) use ($request, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'LIKE', '%' . $request->search . '%');
            }
        });
    }
    return $query;
}
}
