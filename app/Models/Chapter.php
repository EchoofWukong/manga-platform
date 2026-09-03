<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['series_id', 'chapter_number', 'title', 'price_coins', 'is_locked', 'images'];

    protected $casts = [
        'images' => 'array',
    ];

    // Bir bölüm tek bir seriye aittir
    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}