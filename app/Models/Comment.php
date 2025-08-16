<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'author_name',
        'author_email',
        'content',
    ];

    // Relasi: Satu komentar termasuk dalam satu post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relasi: Satu komentar ditulis oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}