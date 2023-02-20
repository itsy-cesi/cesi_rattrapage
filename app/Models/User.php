<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'dob',
    'gender',
    'last_connection',
    'creation_date',
    'email_verified_at'
    ];

    protected $hidden = [
    'password',
    'remember_token',
    ];

    protected $casts = [
    'email_verified_at' => 'datetime',
    ];

    // Your class properties here
    protected string $name;
    protected string $email;
    protected string $password;
    protected string $password_confirmation;
    protected DateTime $dob;
    protected string $gender;
    protected ?DateTime $last_connection;
    protected DateTime $creation_date;
    protected ?DateTime $email_verified_at;
}
