<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardContoller;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\MatakuliahController;

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

Route::resource('user', UserController::class);

Route::resource('profile', ProfileController::class);

Route::resource('document', DocumentController::class);

// User Routes
Route::resource('user', UserController::class);
Route::delete('user/{id}/delete-photo', [UserController::class, 'deletePhoto'])->name('user.delete-photo');

// Document Routes
Route::prefix('user/{user}')->group(function () {
    Route::get('/documents', [UserController::class, 'documents'])->name('user.documents');
    Route::post('/documents', [DocumentController::class, 'store'])->name('user.documents.store');
});

// Document actions
Route::prefix('documents')->group(function () {
    Route::get('/{id}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('/{id}/view', [DocumentController::class, 'view'])->name('documents.view');
    Route::delete('/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');
});

Route::get('/auth', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
