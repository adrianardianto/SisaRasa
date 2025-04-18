<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MitraController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Main dashboard route with role-based redirection
Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'mitra') {
        return redirect()->route('mitra.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Direct mitra dashboard route without middleware alias
Route::get('/mitra/dashboard', [MitraController::class, 'dashboard'])
    ->middleware('auth')
    ->name('mitra.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/mitra.php';
