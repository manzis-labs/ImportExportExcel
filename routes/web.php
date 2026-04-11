<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\AuthController;

// halaman login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// proses login
Route::post('/login', [AuthController::class, 'login']);

// logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('/dashboard', [ImportController::class, 'index'])->name('dashboard');

    // upload excel
    Route::get('/upload', function () {
        return view('upload');
    });

    Route::post('/preview', [ImportController::class, 'preview']);
    Route::post('/import', [ImportController::class, 'import']);

    // CRUD data
    Route::get('/delete/{id}', [ImportController::class, 'delete']);
    Route::get('/edit/{id}', [ImportController::class, 'edit']);
    Route::post('/update/{id}', [ImportController::class, 'update']);

    // export
    Route::get('/export', [ImportController::class, 'export']);
    Route::get('/export-pdf', [ImportController::class, 'exportPDF']);

});


/*
|--------------------------------------------------------------------------
| DEFAULT ROUTE
|--------------------------------------------------------------------------
*/

// kalau buka root → ke login
Route::get('/', function () {
    return redirect('/login');
});