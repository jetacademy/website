<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'image',
        'status',
        'published_at',
        //'count_suka',
        //'count_tertawa',
        //'count_sedih',
        //'count_marah'
    ];
}
