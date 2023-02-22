<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthentificatorController;
use App\Http\Controllers\UserController;

Route::get('/', function ()
{
    return view('pages/home', ['required' => ['bootstrap', 'make_post', 'jquery', 'post_action', 'noty', 'font-awesome']]);
})->name('home');


Route::get('/login', function ()
{
    return Auth::check() ? redirect('/') : view('pages/login', ['required' => ['bootstrap', 'register_form', 'jquery', 'noty', 'font-awesome']]);
})->name('login');

Route::get('/post/{id}', function ($id)
{
    return view('pages/post', ['id' => $id, 'required' => ['bootstrap', 'make_post', 'jquery', 'post_action', 'noty', 'font-awesome']]);
})->name('post');

Route::get('/user/{name}', function ($name)
{
    return view('pages/user', ['name' => $name, 'required' => ['bootstrap', 'make_post', 'jquery', 'post_action', 'noty', 'font-awesome']]);
})->name('user');

Route::get('/settings', function ()
{
    return view('pages/settings', ['required' => ['bootstrap', 'jquery', 'font-awesome']]);
})->name('setting');

Route::any(
    '/logout',
    [AuthentificatorController::class, 'logout']
)->name('logout');
