<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DataStunting extends Model
{
    protected $table = 'data_stunting';

    protected $fillable = [
        'kabupaten_id',
        'puskesmas_id',
        'jumlah_balita',
        'jumlah_stunting',
        'jumlah_bblr',
        'persentase_asi',
        'persentase_pelayanan',
        'tanggal',
        'bulan',
        'tahun',
    ];

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function puskesmas(): BelongsTo
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function hasilDss(): HasOne
    {
        return $this->hasOne(HasilDss::class);
    }
}