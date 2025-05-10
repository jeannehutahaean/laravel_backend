<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersController; // Ubah ke UsersController
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
/*
|--------------------------------------------------------------------------|
| Web Routes                                                              |
|--------------------------------------------------------------------------|
*/
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Menggunakan UsersController untuk routing resource users
Route::resource('users', UsersController::class);
Route::get('/', function () {
    return view('layout');
});

