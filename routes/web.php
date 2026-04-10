<?php

use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/upload', function () {
        return view('upload');
    });

    Route::post('/preview', [ImportController::class, 'preview']);
    Route::post('/import', [ImportController::class, 'import']);

    Route::get('/dashboard', [ImportController::class, 'index'])->name('dashboard');

    Route::get('/delete/{id}', [ImportController::class, 'delete']);
    Route::get('/export', [ImportController::class, 'export']);
    Route::get('/edit/{id}', [ImportController::class, 'edit']);
    Route::post('/update/{id}', [ImportController::class, 'update']);

});

// default arahkan ke login
Route::get('/', function () {
    return redirect('/login');
});

require __DIR__.'/auth.php';