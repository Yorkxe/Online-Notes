<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Laravel\Socialite\Facades\Socialite;

Route::view('/', 'welcome');

Route::resource('Notes', NotesController::class);

Route::get('/Profile/{user}', [ProfileController::class, 'show'])->name('Profile.show');
Route::get('/Profile/{user}/edit', [ProfileController::class, 'edit'])->middleware('auth')->name('Profile.edit');
   
require __DIR__.'/auth.php';

Route::get('/Admin', [AdminController::class, 'show'])->middleware('auth')->name('Admin');

//Route to get the authencated by Google
Route::get('/Google/Redirect', [App\Http\Controllers\GoogleLoginController::class, 'RedirectToGoogle'])->name('Google.Redirect');

//Route to get the received token by Google
Route::get('/Google/Callback', [App\Http\Controllers\GoogleLoginController::class, 'HandleGoogleCallback'])->name('Google.Callback');