<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthentificatorController;

Route::get('/', function ()
{
    return view('pages/home');
})->name('home');


Route::get('/login', function ()
{
    return Auth::check() ? redirect('/') : view('pages/login');
})->name('login');


Route::any(
    '/logout',
    [AuthentificatorController::class, 'logout']
)->name('logout');
