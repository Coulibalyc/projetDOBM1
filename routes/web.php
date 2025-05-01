<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BoursierController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\ImportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/', [BoursierController::class, 'index'])->name('boursiers.index');
Route::get('/boursiers', [BoursierController::class, 'boursiers'])->name('page_boursiers');

Route::get('/boursiers/export/pdf', [BoursierController::class, 'exportPDF']) ->name('boursiers.export.pdf');

Route::get('boursiers/{boursier:IDUS}', [BoursierController::class, 'show'])->name('boursiers.show');
Route::get('boursiers/{boursier:IDUS}/edit', [BoursierController::class, 'edit'])->name('boursiers.edit');


