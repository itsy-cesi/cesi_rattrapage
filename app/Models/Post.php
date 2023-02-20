<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
    'parent',
    'message',
    'author_id',
    'media_1',
    'media_2',
    'media_3',
    'media_4',
    'post_date'
    ];

    protected $casts = [
    'parent' => 'integer',
    'author_id' => 'integer',
    'post_date' => 'datetime'
    ];
}
