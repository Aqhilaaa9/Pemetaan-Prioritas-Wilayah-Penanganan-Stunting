<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Puskesmas extends Model
{
    protected $table = 'puskesmas';

    protected $fillable = [
        'kabupaten_id',
        'nama_puskesmas',
        'latitude',
        'longitude',
    ];

    /**
     * Daftar koordinat default puskesmas di Pulau Lombok
     */
    public static array $knownCoordinates = [
        // Kota Mataram
        'gomong'          => [-8.5835, 116.1042],
        'dasan agung'     => [-8.5772, 116.1018],
        'kekalik'         => [-8.5997, 116.0963],
        'mataram'         => [-8.5838, 116.0984],
        'ampenan'         => [-8.5742, 116.0825],
        'karang pule'     => [-8.6012, 116.0950],
        'tanjung karang'  => [-8.6087, 116.0891],
        'pagesangan'      => [-8.6015, 116.1158],
        'karang taliwang' => [-8.5786, 116.1264],
        'cakranegara'     => [-8.5878, 116.1345],
        'babakan'         => [-8.5982, 116.1432],
        'selaparang'      => [-8.5684, 116.1147],

        // Lombok Barat
        'gerung'          => [-8.6872, 116.1264],
        'narmada'         => [-8.5982, 116.2081],
        'kediri'          => [-8.6534, 116.1601],
        'labuapi'         => [-8.6483, 116.1232],
        'kuripan'         => [-8.7012, 116.1554],
        'gunungsari'      => [-8.5412, 116.1172],
        'meninting'       => [-8.5321, 116.0789],
        'batulayar'       => [-8.5134, 116.0682],
        'batu layar'      => [-8.5134, 116.0682],
        'lingsar'         => [-8.5712, 116.1823],
        'sigerongan'      => [-8.5781, 116.1895],
        'sedau'           => [-8.5892, 116.2412],
        'sekotong'        => [-8.7562, 116.0124],
        'pelangan'        => [-8.7891, 115.9341],
        'eyat mayang'     => [-8.7712, 116.0521],
        'jembatan kembar' => [-8.6892, 116.1042],
        'penimbun'        => [-8.4982, 116.1451],

        // Lombok Tengah
        'praya'           => [-8.7078, 116.2731],
        'kopang'          => [-8.6475, 116.3533],
        'puyung'          => [-8.6841, 116.2482],
        'ubung'           => [-8.6712, 116.2214],
        'jonggat'         => [-8.6712, 116.2214],
        'pringgarata'     => [-8.6012, 116.2514],
        'mantang'         => [-8.6214, 116.3012],
        'batukliang'      => [-8.6214, 116.3012],
        'teratak'         => [-8.5714, 116.3112],
        'janapria'        => [-8.6812, 116.3812],
        'mujur'           => [-8.7612, 116.3412],
        'ganti'           => [-8.7912, 116.3612],
        'sengkol'         => [-8.8142, 116.2812],
        'pujut'           => [-8.8312, 116.2945],
        'kuta'            => [-8.8921, 116.2789],
        'darek'           => [-8.7312, 116.2012],
        'penujak'         => [-8.7512, 116.2412],
        'mangkung'        => [-8.7981, 116.2012],

        // Lombok Timur
        'selong'          => [-8.6492, 116.5342],
        'terara'          => [-8.6256, 116.4253],
        'keruak'          => [-8.7663, 116.4891],
        'masbagik'        => [-8.6212, 116.4712],
        'masbagik baru'   => [-8.6142, 116.4632],
        'sikur'           => [-8.6312, 116.4512],
        'aikmel'          => [-8.5612, 116.5312],
        'aikmel utara'    => [-8.5312, 116.5212],
        'labuhan haji'    => [-8.6612, 116.5712],
        'sakra'           => [-8.6912, 116.5012],
        'rensing'         => [-8.7112, 116.4612],
        'lepak'           => [-8.6812, 116.5412],
        'jerowaru'        => [-8.8112, 116.4912],
        'pringgabaya'     => [-8.5412, 116.6012],
        'batuyang'        => [-8.5212, 116.6212],
        'suela'           => [-8.5012, 116.5612],
        'sambelia'        => [-8.3812, 116.6812],
        'sembalun'        => [-8.3612, 116.5212],
        'montong betok'   => [-8.5912, 116.4412],
        'denggen'         => [-8.6312, 116.5512],
        'korleko'         => [-8.6312, 116.5812],
        'kalijaga'        => [-8.5812, 116.5512],
        'kotaraja'        => [-8.5912, 116.4812],
        'lenek'           => [-8.5712, 116.5012],

        // Lombok Utara
        'tanjung'         => [-8.3512, 116.1557],
        'gangga'          => [-8.3286, 116.1956],
        'kayangan'        => [-8.2812, 116.2612],
        'bayan'           => [-8.2612, 116.3912],
        'senaru'          => [-8.3112, 116.4012],
        'pemenang'        => [-8.4012, 116.1012],
        'nipah'           => [-8.4312, 116.0612],
        'santong'         => [-8.3112, 116.2912],
    ];

    protected static function booted()
    {
        static::saving(function ($puskesmas) {
            if (empty($puskesmas->latitude) || empty($puskesmas->longitude)) {
                $coords = self::findCoordinates($puskesmas->nama_puskesmas, $puskesmas->kabupaten_id);
                if ($coords) {
                    $puskesmas->latitude = $coords[0];
                    $puskesmas->longitude = $coords[1];
                }
            }
        });
    }

    public static function findCoordinates(string $nama, ?int $kabupatenId = null): ?array
    {
        $cleanName = strtolower(trim($nama));
        $cleanName = preg_replace('/^(puskesmas|pkm|pk|rsud)\s+/i', '', $cleanName);
        $cleanName = trim($cleanName);

        // 1. Exact match di tabel dictionary
        if (isset(self::$knownCoordinates[$cleanName])) {
            return self::$knownCoordinates[$cleanName];
        }

        // 2. Partial match
        foreach (self::$knownCoordinates as $key => $coords) {
            if (str_contains($cleanName, $key) || str_contains($key, $cleanName)) {
                return $coords;
            }
        }

        // 3. Fallback ke koordinat Kabupaten dengan sedikit offset deterministik
        if ($kabupatenId) {
            $kab = Kabupaten::find($kabupatenId);
            if ($kab && $kab->latitude && $kab->longitude) {
                $hash = crc32($cleanName);
                $offsetLat = (($hash % 40) - 20) * 0.002;
                $offsetLng = ((($hash >> 5) % 40) - 20) * 0.002;
                return [
                    round($kab->latitude + $offsetLat, 6),
                    round($kab->longitude + $offsetLng, 6),
                ];
            }
        }

        return null;
    }

    public function setNamaPuskesmasAttribute($value)
    {
        $this->attributes['nama_puskesmas'] = ucwords(strtolower(trim($value)));
    }

    public function getNamaPuskesmasAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function dataStunting(): HasMany
    {
        return $this->hasMany(DataStunting::class);
    }
}