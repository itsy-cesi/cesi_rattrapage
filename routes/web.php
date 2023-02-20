<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthentificatorController;
use App\Http\Controllers\UserController;

Route::get('/', function ()
{
    return view('pages/home');
})->name('home');


Route::get('/login', function ()
{
    return Auth::check() ? redirect('/') : view('pages/login');
})->name('login');

Route::get('/post/{id}', function ($id)
{
    return view('pages/post', ['id'=>$id]);
})->name('post');


Route::any(
    '/logout',
    [AuthentificatorController::class, 'logout']
)->name('logout');

Route::any(
    '/list_user',
    [UserController::class, 'index']
);
