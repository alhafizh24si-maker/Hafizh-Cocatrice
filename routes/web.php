<?php

use App\Http\Controllers\DashboardContoller;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/mahasiswa/{param1?}', [MahasiswaController::class, 'show']);

Route::get('/about', function () {
    return view('halaman-about');
});

Route::get('/matakuliah', function () {
    return 'Anda mengakses matakuliah STTD45';
})->name('matakuliah.show');

Route::get('/matakuliah/{param1?}', [MatakuliahController::class, 'show']);

// Resource route untuk Matakuliah
Route::resource('matakuliah', MatakuliahController::class);

Route::get('/matakuliah/show/{kode?}', [MatakuliahController::class, 'show'])
    ->where('kode', '[A-Z0-9]+')
    ->name('matakuliah.show.custom');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/pegawai', [PegawaiController::class, 'index']);

Route::post('question/store', [QuestionController::class, 'store'])
    ->name('question.store');

Route::get('dashboard', [DashboardContoller::class, 'index'])->name('dashboard');

Route::resource('pelanggan', PelangganController::class);

