<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use app\Models\roti;

class RotiImage extends Model {

    use HasFactory;
    protected $table = 'menu_images';
    protected $fillable = ['roti_id', 'image_path', 'thumbnail_path'];

    public function roti(): BelongsTo {
        return $this->belongsTo(Roti::class);
    }
}