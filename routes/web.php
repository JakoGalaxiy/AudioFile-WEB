<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CancionController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/home', [HomeController::class, 'index'])->name('home');
