<?php

use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('upload');
    });

    Route::post('/preview', [ImportController::class, 'preview']);
    Route::post('/import', [ImportController::class, 'import']);
    Route::get('/dashboard', [ImportController::class, 'index']);
    Route::get('/delete/{id}', [ImportController::class, 'delete']);
    Route::get('/export', [ImportController::class, 'export']);

});

Route::get('/', function () {
    return redirect('/login');
});