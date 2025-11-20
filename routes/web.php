<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Ini akan secara otomatis membuat 7 rute CRUD yang mengarah ke UserController
Route::resource('users', UserController::class);

Route::get('/', function () {
    return view('home'); // Sekarang memuat home.blade.php
});

Route::get('/daftar', function () {
    return view('daftar');
})->name('daftar');

// Rute POST: Untuk MENYIMPAN data (INI YANG KURANG)
Route::post('/daftar', [RegisterController::class, 'store'])->name('daftar.store');

// RUTE LOGIN (Tambahkan ini)
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');


