<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, 'index'])->name('movies.index');

Route::get('/fan-favourites', [MovieController::class, 'favorites'])->name('movies.favorites');

Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::post('/movies/{movie}/like', [MovieController::class, 'toggleLike'])->name('movies.like');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'postLogin'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'postRegister'])->middleware('guest');
