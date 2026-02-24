<?php

use App\Http\Controllers\AuthCtrl;
use App\Http\Controllers\DashboardCtrl;
use App\Http\Controllers\UserCtrl;
use App\Http\Controllers\PerangkatCtrl; // <-- Tambahkan import ini
use App\Http\Controllers\KategoriCtrl;
use App\Http\Controllers\RuanganCtrl;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthCtrl::class, 'login']);
Route::post('/login/check',[AuthCtrl::class, 'proses_login'])->name('login.check');
Route::post('/logout', [AuthCtrl::class, 'logout'])->name('logout');
Route::get('/dashboard',[DashboardCtrl::class, 'dashboard']);

# User
Route::get('/user/data_user',[UserCtrl::class, 'data_user']);
Route::post('/user/data_user', [UserCtrl::class, 'store_user']);
Route::get('/user/data_user/{id}/delete',[UserCtrl::class, 'delete_user']);

# Perangkat IT
Route::get('/perangkat', [PerangkatCtrl::class, 'data_perangkat']);
Route::post('/perangkat/store', [PerangkatCtrl::class, 'store_perangkat']);
Route::get('/perangkat/{id}/delete', [PerangkatCtrl::class, 'delete_perangkat']);

# Kategori Perangkat
Route::get('/kategori', [KategoriCtrl::class, 'data_kategori']);
Route::post('/kategori/store', [KategoriCtrl::class, 'store_kategori']);
Route::get('/kategori/{id}/delete', [KategoriCtrl::class, 'delete_kategori']);

# Ruangan
Route::get('/ruangan', [RuanganCtrl::class, 'data_ruangan']);
Route::post('/ruangan/store', [RuanganCtrl::class, 'store_ruangan']);
Route::get('/ruangan/{id}/delete', [RuanganCtrl::class, 'delete_ruangan']);
