<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth')->group(function() {
    Route::get('/data', [EventController::class, 'getPage'])->name('data');

    Route::get('/charts', function() {
        return Inertia::render('Charts');
    })->name('charts');

    Route::get('/users', [UserController::class, 'getPage'])->name('users');

    Route::get('/users/create-user', [UserController::class, 'getCreateUserPage'])->name('create-user');

    Route::post('/users/store-created-user', [UserController::class, 'store'])->name('store-created-user');

    Route::get('/users/delete-user/{id}', [UserController::class, 'destroy'])->name('delete-user');

    Route::get('/users/edit-user/{id}', [UserController::class, 'getEditUserPage'])->name('edit-user');

    Route::get('/get-user/{id}', [UserController::class, 'getUser'])->name('get-user');

    Route::post('/users/store-edited-user/{id}', [UserController::class, 'update'])->name('store-edited-user');
});



Route::post('/submit-form', [EventController::class, 'store'])->name('submit-form');

Route::get('/get-events', [EventController::class, 'index'])->name('get-events');

Route::get('/get-users', [UserController::class, 'index'])->name('get-users');



require __DIR__.'/auth.php';
