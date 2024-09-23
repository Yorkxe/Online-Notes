<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function () {
    //url路徑/profile/{user}       透過ProfileContoller中的
    Route::get('/Profile/{user}', [ProfileController::class, 'show'])->name('Profile.show');
    Route::get('/Profile/{user}/edit', [ProfileController::class, 'edit'])->name('Profile.edit');
});
    

require __DIR__.'/auth.php';

Route::resource('Notes', NotesController::class)->middleware('auth');

Route::middleware('auth')->get('Admin', function(){
    if(Auth::User()->authority != 1){
        return redirect()->route('Profile.show', [
            'user' => Auth()->User()->id,
        ])->withErrors(['error' => 'You have no access to see this page']); 
    }else{
        return view('Admin');
    }
})->name('Admin');
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