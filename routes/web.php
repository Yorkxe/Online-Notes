<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;

Route::view('/', 'welcome');

Route::view('index', 'index')->name('index');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::resource('Notes', NotesController::class)->middleware('auth');

//The GET method is not supported for route Notes. Supported methods: POST.
// Route::resource('Notes', NotesController::class)->middleware('auth')->except(['index', 'show']);


// Route [Notes.create] not defined.
// Route::controller(NotesController::class)->group(function () {
//     Route::get('/Notes', 'index');
//     Route::get('/Notes/{Notes}', 'show');
//     Route::put('/Notes/{Notes}/edit', 'edit')->middleware('auth');
//     Route::get('/Notes/create', 'create')->middleware('auth');
// });

// Route [Notes.index] not defined.
// Route::resource('Notes', 'NotesController', [
//     'except' => [
//         'index',
//         'show'
//     ]
// ])->middleware(['web', 'auth']);