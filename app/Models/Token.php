<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'token',
    'expiration_date',
    'user_agent',
    ];

    protected $casts = [
    'user_id' => 'integer',
    'token' => 'string',
    'expiration_date' => 'datetime',
    'user_agent' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
