<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'name' => 'Florian Dima'
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'name' => Auth::user()->name,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/data', [EventController::class, 'getPage'])->name('data');

Route::get('/charts', function() {
    return Inertia::render('Charts');
})->name('charts');

Route::get('/users', function() {
    return Inertia::render('Users');
})->name('users');

Route::post('/submit-form', [EventController::class, 'store'])->name('submit-form');

Route::get('/get-data', [EventController::class, 'index'])->name('get-data');



require __DIR__.'/auth.php';
