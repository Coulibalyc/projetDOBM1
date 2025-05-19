<?php

namespace App\Http\Controllers;

use App\Models\boursiers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
        // filtre par genre
        if ($request->filled('sexe')) {
            $query->where('sexe', $request->sexe);
        }
        
        // Récupération des boursiers avec pagination
        $boursiers = $query->orderBy('nom')->paginate(10);
        
        // Récupération des listes pour les filtres
        $pays = boursiers::distinct()->pluck('pays')->sort()->values();
        $cycles = boursiers::distinct()->pluck('cycle_formation_a_faire')->sort()->values();
        $annees_scolaires = boursiers::distinct()->pluck('annee_scolaire')->sort()->values();
        $sexe = boursiers::distinct()->pluck('sexe')->sort()->values();
        
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
        
        return view('boursiers.Page_boursiers', compact('boursiers', 'pays', 'cycles', 'annees_scolaires', 'stats','sexe'));
    }

    // Affiche le détail d'un boursier
   
      public function show(boursiers $boursier)
    {
        return view('boursiers.boursier_show', compact('boursier'));
    }


    // Affiche le formulaire d'édition (en lecture seule maintenant)


    // Export des données
    public function exportPDF(Request $request)
    {
        // 1. Construire la même query que pour l’affichage
        $query = boursiers::query();
        if ($request->filled('search')) {
            $query->where(function($q) use($request){
                $q->where('nom','like','%'.$request->search.'%')
                  ->orWhere('prenoms','like','%'.$request->search.'%');
            });
        }
        if ($request->filled('pays')) {
            $query->where('pays', $request->pays);
        }
        if ($request->filled('cycle')) {
            $query->where('cycle_formation_a_faire', $request->cycle);
        }
        if ($request->filled('annee_scolaire')) {
            $query->where('annee_scolaire', $request->annee_scolaire);
        }
        if ($request->filled('sexe')) {
            $query->where('sexe', $request->sexe);
        }
        // Ajoute ici les autres filtres avancés si besoin…
    
        // 2. Charger tous les boursiers filtrés
        $boursiers = $query->orderBy('nom')->get();
    
        // 3. Générer le PDF depuis une vue dédiée
        $pdf = Pdf::loadView('boursiers.pdf', compact('boursiers'))
                  ->setPaper('a4', 'landscape')  // orientation paysage
                  ->setWarnings(false);          // ne pas afficher les avertissements
    
        // 4. Retourner le PDF en streaming
        return $pdf->stream('liste_boursiers.pdf');
    }


    public function messagerie_boursiers()
{
    // récupère les messages de l’utilisateur (à implémenter selon ton modèle)
    
    return view('boursier.messagerie_boursiers');
}

    
}