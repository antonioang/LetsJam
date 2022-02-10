<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\MusicSheetController;
use \App\Http\Controllers\SongController;
use \App\Http\Controllers\MainController;
use \App\Http\Controllers\ProfileController;

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
//
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/home', [MainController::class,'index'])->name('home');

Route::get('/aboutUs', [MainController::class,'aboutUs']);

Route::middleware(['user-role'])->group(function() {
    Route::get('/admin/manageUsers', [MainController::class, 'manageUsers']);
    Route::post('/admin/manageUsers', [MainController::class, 'promoteUsers']);
    Route::post('/admin/deleteUsers', [MainController::class, 'deleteUsers']);
    Route::get('/admin/verifyMusicsheet', [MainController::class, 'indexSheets']);
    Route::post('/admin/verifyMusicsheet', [MainController::class, 'indexSheets']);
    Route::post('/admin/verifySingleMusicsheet', [MainController::class, 'verifySheets']);
});

Route::middleware(['auth'])->group(function() {

    Route::post('musicsheets/filter', [MusicSheetController::class, 'filter'])->name('filter');
    Route::post('musicsheets/getEmptyScore', [MusicSheetController::class, 'getEmptyScore']);
    Route::get('musicsheets/brani', [MusicSheetController::class, 'searchSong']);
    Route::post('musicsheets/analyze', [MusicSheetController::class, 'analyzeScore']);
    Route::post('musicsheets/like', [MusicSheetController::class, 'like']);
    Route::post('/musicsheets/modify', [MusicSheetController::class, 'modify'])->name('modify');
    Route::post('musicsheets/dislike', [MusicSheetController::class, 'dislike']);
    Route::post('musicsheets/addComment', [MusicSheetController::class, 'addComment']);
    Route::post('musicsheets/getReplies', [MusicSheetController::class, 'getReplies']);
    Route::post('musicsheets/getScoreWithOnlyParts', [MusicSheetController::class, 'extractInstrumentPart']);
    Route::resource('musicsheets', MusicSheetController::class);
    Route::resource('songs', SongController::class);
    Route::post('songs/filter', [SongController::class, 'filter'])->name('filterSongs');
    Route::get('/profilo',[ProfileController::class, 'index']);
    Route::get('/modifica-profilo',[ProfileController::class, 'Modify']);
    Route::post('/modifica-profilo',[ProfileController::class, 'ModifyProfile']);
});

require __DIR__.'/auth.php';
