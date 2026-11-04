<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use App\Models\roti_image;

class roti extends Model
{
    use HasFactory;
    protected $table = 'roti';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'category',
        'tanggal_produksi',
        'tanggal_kadaluarsa'
    ];

    protected $casts = [
        'tanggal_produksi'   => 'datetime',
        'tanggal_kadaluarsa' => 'datetime',
    ];

    public function images(): HasMany {
        return $this->hasMany(RotiImage::class);
    }

    protected static function booted()
    {
        static::creating(function ($roti) {
            // Otomatis ngisi tanggal & jam saat ini
            $roti->tanggal_produksi = $roti->tanggal_produksi ?? now();

            // Otomatis set kadaluarsa 3 hari dari tanggal produksi
            $roti->tanggal_kadaluarsa = $roti->tanggal_kadaluarsa ?? $roti->tanggal_produksi->copy()->addDays(3);
        });
    }

    
}
