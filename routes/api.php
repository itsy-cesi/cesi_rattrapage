<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthentificatorController;
use App\Http\Controllers\PostController;

//For safety reasons, all api route are hashed
Route::post(
    '/5AE4A0A137B30827B0C9DAE7C2F0EC7B',
    [AuthentificatorController::class, 'login']
)->name('api.login');

Route::post(
    '/14EEF13B5D89D91446CC607A1E462E15',
    [AuthentificatorController::class, 'register']
)->name('api.register');

Route::post(
    '/7E1A8BB6D9675619C650046DEABCD287',
    [PostController::class, 'store']
)->name('api.make_post');

Route::post(
    '/1904860BDD334038436B01B4E22386B9',
    [PostController::class, 'destroy']
)->name('api.delete_post');
