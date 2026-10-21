<?php

use App\Http\Controllers\FrontendPreviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendPreviewController::class, 'index'])->name('home');
Route::get('/events', [FrontendPreviewController::class, 'catalog'])->name('catalog');
Route::get('/me/saved-events', [FrontendPreviewController::class, 'saved'])->name('saved');
Route::get('/me/profile', [FrontendPreviewController::class, 'profile'])->name('profile');
Route::get('/register', [FrontendPreviewController::class, 'login'])->name('register');
Route::get('/login', [FrontendPreviewController::class, 'login'])->name('login');
Route::get('/contoh/admin', [FrontendPreviewController::class, 'admin'])->name('preview.admin');
Route::get('/contoh/komponen', [FrontendPreviewController::class, 'components'])->name('preview.components');
