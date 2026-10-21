<?php

use App\Http\Controllers\FrontendPreviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendPreviewController::class, 'index'])->name('home');
Route::get('/contoh/admin', [FrontendPreviewController::class, 'admin'])->name('preview.admin');
