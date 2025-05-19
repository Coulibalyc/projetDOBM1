<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoursierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

// Regroupe toutes les routes internes derrière l'authentification
Route::middleware('auth')->group(function () {
    // Tableau de bord (page index)
    Route::get('/', [BoursierController::class, 'index'])
         ->name('dashboard');

     Route::get('/mesagerie', [BoursierController::class, 'messagerie_boursiers'])
         ->name('me') ;
     // Statistiques globales
     Route::get('/statistiques', [App\Http\Controllers\BoursierController::class, 'statistiques'])
     ->name('statistiques');

     // Détail d’un boursier
     Route::get('/boursiers/{boursier}', [BoursierController::class, 'show'])
     ->name('boursier.show');

    // Liste des boursiers
    Route::get('/boursiers', [BoursierController::class, 'boursiers'])
         ->name('page_boursiers');

    // Export PDF filtré
    Route::get('/boursiers/export/pdf', [BoursierController::class, 'exportPDF'])
         ->name('boursiers.export.pdf');

    // Profil utilisateur (édition, mise à jour, suppression)
    Route::get('/profile', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
         ->name('profile.destroy');
});

// Routes d'authentification (login, register, etc.)
