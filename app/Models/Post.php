<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
    'message',
    'author_id',
    'media_1',
    'media_2',
    'media_3',
    'media_4',
    'post_date'
    ];

    protected $casts = [
    'author_id' => 'integer',
    'message' => 'string|nullable',
    'media_1' => 'string|nullable',
    'media_2' => 'string|nullable',
    'media_3' => 'string|nullable',
    'media_4' => 'string|nullable',
    'post_date' => 'datetime'
    ];
}
