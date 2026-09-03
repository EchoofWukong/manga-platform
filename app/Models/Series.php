<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'cover_image', 'status', 'views'];

    // Bir serinin birden fazla bölümü olur
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    // Bir serinin birden fazla türü (kategorisi) olur
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}