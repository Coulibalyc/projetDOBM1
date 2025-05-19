<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSousDirectrice
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user(); // Auth::check() est implicite ici

        // Vérifie que l'utilisateur est connecté et a le rôle correct
        if ($user && $user->role === 'sous-directrice') {
            return $next($request);
        }
        
        // Sinon, accès interdit
        abort(403, 'Accès réservé à la sous-directrice.');
    }
}

