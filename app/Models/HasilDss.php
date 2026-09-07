<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilDss extends Model
{
    protected $table = 'hasil_dss';

    protected $fillable = [
        'data_stunting_id',
        'bulan',
        'tahun',
        'nilai_dss',
        'ranking',
        'prioritas',
    ];

    public function dataStunting(): BelongsTo
    {
        return $this->belongsTo(DataStunting::class);
    }
}