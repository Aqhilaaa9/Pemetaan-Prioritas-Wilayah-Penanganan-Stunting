<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kabupaten extends Model
{
    protected $table = 'kabupaten';

    protected $fillable = [
        'nama_kabupaten',
        'latitude',
        'longitude',
    ];

    public function puskesmas(): HasMany
    {
        return $this->hasMany(Puskesmas::class);
    }

    public function dataStunting(): HasMany
    {
        return $this->hasMany(DataStunting::class);
    }
}