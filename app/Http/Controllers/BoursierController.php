<?php

namespace App\Http\Controllers;

use App\Models\boursiers;
use Illuminate\Http\Request;

class BoursierController 
{
    // Affiche la liste des boursiers avec statistiques (page d'accueil / tableau de bord)
    public function index(Request $request)
    {
        $query = boursiers::query();

        // Filtrage dynamique complet
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', '%'.$request->search.'%')
                  ->orWhere('prenoms', 'like', '%'.$request->search.'%')
                  ->orWhere('filiere_a_faire_renseigne', 'like', '%'.$request->search.'%')
                  ->orWhere('etablissement_accueil', 'like', '%'.$request->search.'%');
            });
        }
        
        if ($request->filled('pays')) {
            $query->where('pays', $request->pays);
        }
        
        if ($request->filled('cycle')) {
            $query->where('cycle_formation_a_faire', $request->cycle);
        }
        
        if ($request->filled('annee')) {
            $query->where('annee_scolaire', $request->annee);
        }

        // Données pour les filtres
        $countries = boursiers::distinct('pays')->orderBy('pays')->pluck('pays');
        $schoolYears = boursiers::distinct('annee_scolaire')->orderByDesc('annee_scolaire')->pluck('annee_scolaire');
        $cycles = ['1er cycle', '2nd cycle', 'Doctorat'];

        // Statistiques globales
        $stats = [
            'total' => boursiers::count(),
            'totalFiltre' => $query->count(),
            'parPays' => boursiers::select('pays')
                ->selectRaw('count(*) as count')
                ->groupBy('pays')
                ->orderByDesc('count')
                ->get(),
            'parCycle' => boursiers::select('cycle_formation_a_faire')
                ->selectRaw('count(*) as count')
                ->groupBy('cycle_formation_a_faire')
                ->get(),
            'parStatut' => boursiers::select('decision')
                ->selectRaw('count(*) as count')
                ->groupBy('decision')
                ->get(),
            'parFiliere' => boursiers::select('diplome_a_faire')
                ->selectRaw('count(*) as count')
                ->groupBy('diplome_a_faire')
                ->orderByDesc('count')
                ->get(),
            'recentBoursiers' => boursiers::inRandomOrder()->take(5)->get(),
        ];

        return view('boursiers.index', [
            'boursiers' => $query->paginate(15),
            'stats' => $stats,
            'countries' => $countries,
            'schoolYears' => $schoolYears,
            'cycles' => $cycles,
            'filters' => $request->all()
        ]);
    }

    // Méthode pour la page de liste des boursiers
    public function boursiers(Request $request)
    {
        // Construction de la requête de base
        $query = boursiers::query();
        
        // Filtre par recherche (nom ou prénom)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                  ->orWhere('prenoms', 'LIKE', "%{$search}%");
            });
        }
        
        // Filtre par pays
        if ($request->filled('pays')) {
            $query->where('pays', $request->pays);
        }
        
        // Filtre par cycle de formation
        if ($request->filled('cycle')) {
            $query->where('cycle_formation_a_faire', $request->cycle);
        }
        
        // Filtre par année scolaire
        if ($request->filled('annee_scolaire')) {
            $query->where('annee_scolaire', $request->annee_scolaire);
        }
        
        // Récupération des boursiers avec pagination
        $boursiers = $query->orderBy('nom')->paginate(10);
        
        // Récupération des listes pour les filtres
        $pays = boursiers::distinct()->pluck('pays')->sort()->values();
        $cycles = boursiers::distinct()->pluck('cycle_formation_a_faire')->sort()->values();
        $annees_scolaires = boursiers::distinct()->pluck('annee_scolaire')->sort()->values();
        
        // Ajout des statistiques nécessaires pour la vue
        $stats = [
            'total' => boursiers::count(),
            'totalFiltre' => $query->count(),
            'parPays' => boursiers::select('pays')
                ->selectRaw('count(*) as count')
                ->groupBy('pays')
                ->orderByDesc('count')
                ->get(),
            'parCycle' => boursiers::select('cycle_formation_a_faire')
                ->selectRaw('count(*) as count')
                ->groupBy('cycle_formation_a_faire')
                ->get(),
            'parStatut' => boursiers::select('decision')
                ->selectRaw('count(*) as count')
                ->groupBy('decision')
                ->get(),
            'parFiliere' => boursiers::select('diplome_a_faire')
                ->selectRaw('count(*) as count')
                ->groupBy('diplome_a_faire')
                ->orderByDesc('count')
                ->get(),
            'recentBoursiers' => boursiers::inRandomOrder()->take(5)->get(),
        ];
        
        return view('boursiers.Page_boursiers', compact('boursiers', 'pays', 'cycles', 'annees_scolaires', 'stats'));
    }

    // Affiche le détail d'un boursier
    public function show($idus)
    {
        $boursier = boursiers::findOrFail($idus);
        
        // Statistiques similaires pour contexte
        $stats = [
            'totalMemePays' => boursiers::where('pays', $boursier->pays)->count(),
            'totalMemeFiliere' => boursiers::where('filiere_a_faire_renseigne', $boursier->filiere_a_faire_renseigne)->count(),
        ];

        return view('boursiers.show', [
            'boursier' => $boursier,
            'stats' => $stats
        ]);
    }

    // Affiche le formulaire d'édition (en lecture seule maintenant)
    public function edit($idus)
    {
        $boursier = boursiers::findOrFail($idus);

        return view('boursiers.show', [
            'boursier' => $boursier,
            'readOnly' => true,
            'countries' => boursiers::distinct('pays')->orderBy('pays')->pluck('pays'),
            'cycles' => ['Licence', 'Master', 'Doctorat']
        ]);
    }

    // Export des données
    public function export(Request $request)
    {
        // Logique d'exportation à implémenter
        // ...
        
        return redirect()->back()->with('success', 'Export en cours de téléchargement.');
    }
}