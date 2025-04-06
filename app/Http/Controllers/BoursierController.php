<?php

namespace App\Http\Controllers;

use App\Models\boursiers;
use Illuminate\Http\Request;

class BoursierController 
{
    // Affiche la liste des boursiers avec statistiques
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
        $cycles = ['Licence', 'Master', 'Doctorat'];

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

    // Méthode supplémentaire pour la route Page_boursiers


    // Affiche le formulaire de création
    public function create()
    {
        return view('boursiers.Page_boursiers', [
            'countries' => boursiers::distinct('pays')->orderBy('pays')->pluck('pays'),
            'cycles' => ['Licence', 'Master', 'Doctorat']
        ]);
    }

    // Enregistre un nouveau boursier
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'filiere_a_faire_renseigne' => 'required|string|max:255',
            'cycle_formation_a_faire' => 'required|string|in:Licence,Master,Doctorat',
            'etablissement_accueil' => 'required|string|max:255',
            'mont_bourse' => 'required|numeric',
            'annee_scolaire' => 'required|string|max:255',
            'decision' => 'required|string|in:accepté,en attente,refusé'
        ]);

        boursiers::create($validated);

        return redirect()->route('boursiers.index')
                         ->with('success', 'Boursier créé avec succès');
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

    // Affiche le formulaire d'édition
    public function edit($idus)
    {
        $boursier = boursiers::findOrFail($idus);

        return view('boursiers.edit', [
            'boursier' => $boursier,
            'countries' => boursiers::distinct('pays')->orderBy('pays')->pluck('pays'),
            'cycles' => ['Licence', 'Master', 'Doctorat']
        ]);
    }

    // Met à jour un boursier
    public function update(Request $request, $idus)
    {
        $boursier = boursiers::findOrFail($idus);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenoms' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'filiere_a_faire_renseigne' => 'required|string|max:255',
            'cycle_formation_a_faire' => 'required|string|in:Licence,Master,Doctorat',
            'etablissement_accueil' => 'required|string|max:255',
            'mont_bourse' => 'required|numeric',
            'annee_scolaire' => 'required|string|max:255',
            'decision' => 'required|string|in:accepté,en attente,refusé'
        ]);

        $boursier->update($validated);

        return redirect()->route('boursiers.show', $boursier->IDUS)
                         ->with('success', 'Boursier mis à jour avec succès');
    }

    // Supprime un boursier
    public function destroy($idus)
    {
        $boursier = boursiers::findOrFail($idus);
        $boursier->delete();

        return redirect()->route('boursiers.index')
                         ->with('success', 'Boursier supprimé avec succès');
    }

    // Tableau de bord
    public function dashboard(Request $request)
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
        $cycles = ['Licence', 'Master', 'Doctorat'];

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

    public function boursiers(Request $request)
{
    // Récupérer les pays et années scolaires pour les filtres
    $countries = boursiers::distinct()->pluck('pays');
    $schoolYears = boursiers::distinct()->pluck('annee_scolaire');

    // Appliquer les filtres si des paramètres sont passés
    $query = boursiers::query();

    if ($request->has('search') && $request->search != '') {
        $query->where('nom', 'like', '%' . $request->search . '%')
              ->orWhere('prenoms', 'like', '%' . $request->search . '%');
    }

    if ($request->has('pays') && $request->pays != '') {
        $query->where('pays', $request->pays);
    }

    if ($request->has('cycle') && $request->cycle != '') {
        $query->where('cycle_formation_a_faire', $request->cycle);
    }

    if ($request->has('annee') && $request->annee != '') {
        $query->where('annee_scolaire', $request->annee);
    }

    // Récupérer les boursiers après application des filtres
    $boursiers = $query->paginate(10);

    // Retourner la vue avec les boursiers et les options de filtres
    return view('boursiers.Page_boursiers', compact('boursiers', 'countries', 'schoolYears'));
}


    // Export des données
    public function export(Request $request)
    {
        // Implémentez votre logique d'export ici
        // (Excel, CSV, PDF, etc.)
    }
}
