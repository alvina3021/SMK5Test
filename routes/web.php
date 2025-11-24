<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataPribadiController;
use App\Http\Controllers\RiasecController;
use App\Http\Controllers\MotivasiBelajarController;
use App\Http\Controllers\StudiHabitController;
use App\Http\Controllers\SosialEmosionalController;
use App\Http\Controllers\PreferensiKelompokController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    // 2. Rute Halaman Instruksi (Menggunakan data_pribadi.blade.php)
    Route::get('/data-pribadi', [DataPribadiController::class, 'instruksi'])->name('data_pribadi');

    // 3. Rute Halaman Formulir Pertanyaan (Menggunakan data_pribadi_form.blade.php)
   // Route::get('/data-pribadi/form', [DataPribadiController::class, 'form'])->name('data_pribadi.form');

// STEP 1: DATA DIRI
        // HALAMAN 1 (Menggunakan /form)
    Route::get('/data-pribadi/form', [DataPribadiController::class, 'form'])->name('data_pribadi.form');
    Route::post('/data-pribadi/form', [DataPribadiController::class, 'storeForm'])->name('data_pribadi.store_form');

    // STEP 2: DATA ORANG TUA
    Route::get('/data-pribadi/step2', [DataPribadiController::class, 'step2'])->name('data_pribadi.step2');
    Route::post('/data-pribadi/step2', [DataPribadiController::class, 'storeStep2'])->name('data_pribadi.store_step2');

    // Step 3: Data Wali
    Route::get('/data-pribadi/step3', [DataPribadiController::class, 'step3'])->name('data_pribadi.step3');
    Route::post('/data-pribadi/step3', [DataPribadiController::class, 'storeStep3'])->name('data_pribadi.store_step3');

    // Route Halaman Selesai
    Route::get('/data-pribadi/selesai', [DataPribadiController::class, 'finish'])->name('data_pribadi.finish');

    // --- RIASEC ROUTES ---

    // 1. Pintu Masuk Utama (Instruksi ATAU Finish - Tergantung Status DB)
    Route::get('/riasec', [RiasecController::class, 'index'])->name('riasec.index');

    // 2. Halaman Form Tes
    Route::get('/riasec/tes', [RiasecController::class, 'form'])->name('riasec.form');

    // 3. Simpan Jawaban
    Route::post('/riasec/tes', [RiasecController::class, 'store'])->name('riasec.store');

    // 4. Halaman Selesai (Opsional, karena index sudah menghandle ini)
    Route::get('/riasec/selesai', [RiasecController::class, 'finish'])->name('riasec.finish');

    // Halaman Instruksi
    Route::get('/motivasi-belajar', [MotivasiBelajarController::class, 'index'])->name('motivasi.index');

    // Halaman Form Soal
    Route::get('/motivasi-belajar/tes', [MotivasiBelajarController::class, 'form'])->name('motivasi.form');

    // Proses Simpan Data
    Route::post('/motivasi-belajar/tes', [MotivasiBelajarController::class, 'store'])->name('motivasi.store');

    // Halaman Selesai Tes Motivasi Belajar
    Route::get('/motivasi-belajar/selesai', [MotivasiBelajarController::class, 'finish'])->name('motivasi.finish');

    // STUDI HABIT ROUTES
    // Halaman Instruksi
    Route::get('/studi-habit', [StudiHabitController::class, 'index'])->name('studi_habit.index');

    // Halaman Form Soal (Step 1: Studi Habit)
    Route::get('/studi-habit/tes', [StudiHabitController::class, 'form'])->name('studi_habit.form');

    // Proses Simpan Data Step 1
    Route::post('/studi-habit/tes', [StudiHabitController::class, 'store'])->name('studi_habit.store');

    // Halaman Step 2 (Gaya Belajar)
    Route::get('/studi-habit/step2', [StudiHabitController::class, 'step2'])->name('studi_habit.step2');

    // Proses Simpan Data Step 2
    Route::post('/studi-habit/step2', [StudiHabitController::class, 'storeStep2'])->name('studi_habit.store_step2');

    // Halaman Selesai Tes Studi Habit
    Route::get('/studi-habit/selesai', [StudiHabitController::class, 'finish'])->name('studi_habit.finish');

    // SOSIAL EMOSIONAL ROUTES
    // Halaman Instruksi
    Route::get('/sosial-emosional', [SosialEmosionalController::class, 'index'])->name('sosial_emosional.index');

    // Halaman Form Soal (Step 1: Data Sosial dan Emosional)
    Route::get('/sosial-emosional/tes', [SosialEmosionalController::class, 'form'])->name('sosial_emosional.form');

    // Proses Simpan Data Step 1
    Route::post('/sosial-emosional/tes', [SosialEmosionalController::class, 'store'])->name('sosial_emosional.store');

    // Halaman Step 2 (Kesehatan Mental)
    Route::get('/sosial-emosional/step2', [SosialEmosionalController::class, 'step2'])->name('sosial_emosional_step2');

    // Proses Simpan Data Step 2
    Route::post('/sosial-emosional/step2', [SosialEmosionalController::class, 'storeStep2'])->name('sosial_emosional_step2.store');

    // Halaman Selesai Tes Sosial Emosional
    Route::get('/sosial-emosional/selesai', [SosialEmosionalController::class, 'finish'])->name('sosial_emosional.finish');

    // PREFERENSI KELOMPOK ROUTES
    // Halaman Instruksi
    Route::get('/preferensi-kelompok', [PreferensiKelompokController::class, 'index'])->name('preferensi_kelompok.index');

    // Halaman Form Soal
    Route::get('/preferensi-kelompok/tes', [PreferensiKelompokController::class, 'form'])->name('preferensi_kelompok.form');

    // Proses Simpan Data
    Route::post('/preferensi-kelompok/tes', [PreferensiKelompokController::class, 'store'])->name('preferensi_kelompok.store');

    // Halaman Selesai Tes Preferensi Kelompok
    Route::get('/preferensi-kelompok/selesai', [PreferensiKelompokController::class, 'finish'])->name('preferensi_kelompok.finish');
});
