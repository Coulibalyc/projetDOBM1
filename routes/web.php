<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoursierController;
use App\Http\Controllers\MessageController;
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

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create/individual', [MessageController::class, 'createIndividual'])->name('messages.create.individual');
    Route::post('/messages/individual', [MessageController::class, 'storeIndividual'])->name('messages.store.individual');
    Route::get('/messages/create/group', [MessageController::class, 'createGroup'])->name('messages.create.group');
    Route::post('/messages/group', [MessageController::class, 'storeGroup'])->name('messages.store.group');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');

    // Profil utilisateur (édition, mise à jour, suppression)
    Route::get('/profile', [ProfileController::class, 'edit'])
         ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
         ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
         ->name('profile.destroy');
});

// Routes d'authentification (login, register, etc.)
