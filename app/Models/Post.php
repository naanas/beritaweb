<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'image',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relasi: Satu post termasuk dalam satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Satu post ditulis oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu post memiliki banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}