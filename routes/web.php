<?php

use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');
Route::inertia('/onlineform', 'OnlineForm')->name('online-form');
Route::inertia('/admin', 'Admin')->name('admin');
