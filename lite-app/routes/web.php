<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashedNoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//to list all notes of login user -index
// Route::get('/notes',);

//to display single note -show
// Route::get('/notes/{note}',);

//to create -create
// Route::get('/notes/create',);

//to save the note -store
// Route::post('/notes',);

//to edit the note -edit
// Route::get('/notes/{note}/edit',);

//to update the note -update [put or patch methods]
// Route::put('/notes/{note}',);

//to delete the note -destroy
// Route::delete('/notes/{note}',);

Route::resource('/notes', NoteController::class)->middleware(['auth']);
//adding auth middleware

Route::get('/trashed', [TrashedNoteController::class, 'index'])->middleware('auth')->name('trashed.index');

Route::get('/trashed/{note}', [TrashedNoteController::class, 'show'])->withTrashed()->middleware('auth')->name('trashed.show');

Route::put('/trashed/{note}', [TrashedNoteController::class, 'update'])->withTrashed()->middleware('auth')->name('trashed.update');

Route::delete('/trashed/{note}', [TrashedNoteController::class, 'destroy'])->withTrashed()->middleware('auth')->name('trashed.destroy');

// Route::prefix('/trashed')->name('trashed.')->middleware('auth')->group(function(){
//     Route::get('/', [TrashedNoteController::class, 'index'])->name('index');
//     Route::get('/', [TrashedNoteController::class, 'show'])->name('show')->withTrashed();
//     Route::put('/', [TrashedNoteController::class, 'update'])->name('update')->withTrashed();
//     Route::delete('/', [TrashedNoteController::class, 'destroy'])->name('destroy')->withTrashed();
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
