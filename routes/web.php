<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Home')->name('home');
Route::inertia('/onlineform', 'OnlineForm')->name('online-form');

Route::prefix('admin')->name('admin.')->group(function () {

    // Guest Admin Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminController::class, 'login']);
        Route::get('/signup', [AdminController::class, 'showSignUp'])->name('signup');
        Route::post('/signup', [AdminController::class, 'signUp']);
    });

    // Authenticated Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('dashboard');

        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});

require __DIR__.'/auth.php';
