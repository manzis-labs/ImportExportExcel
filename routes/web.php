<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;

Route::get('/', function () {
    return view('upload');
});

Route::post('/import', [ImportController::class, 'upload']);
Route::post('/preview', [ImportController::class, 'preview']);
Route::post('/import', [ImportController::class, 'import']);
Route::get('/dashboard', [ImportController::class, 'index']);
Route::get('/delete/{id}', [ImportController::class, 'delete']);