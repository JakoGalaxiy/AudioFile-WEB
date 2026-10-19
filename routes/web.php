<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CancionController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

Route::get('/', [CancionController::class, 'index'])->name('home');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/profile', function () {
    return view('auth.profile');
})->name('profile');

Route::get('/search', function (Request $request) {
    $query = $request->input('query');
    return view('search', compact('query'));
})->name('search.view');