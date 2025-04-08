@extends('layouts.app')

@section('content')
<div class="flex min-h-screen flex-col">

    <main class="flex-1">
        <div class="container py-6">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-3xl font-bold">Liste des Boursiers</h2>
                <!-- Bouton d'ajout supprimé -->
            </div>

            <div class="mb-6 rounded-lg border bg-white shadow-sm">
                <div class="border-b px-6 py-4">
                    <h3 class="text-lg font-medium">Filtres</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('page_boursiers') }}" method="GET">
                        <div class="grid gap-4 md:grid-cols-4">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input
                                    type="search"
                                    name="search"
                                    placeholder="Rechercher..."
                                    class="w-full rounded-md border border-gray-300 pl-8 py-2"
                                    value="{{ request('search') }}"
                                />
                            </div>
                            <select name="pays" class="w-full rounded-md border border-gray-300 py-2">
                                <option value="">Tous les pays</option>
                                @foreach($pays as $p)
                                    <option value="{{ $p }}" {{ request('pays') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                            <select name="cycle" class="w-full rounded-md border border-gray-300 py-2">
                                <option value="">Tous les cycles</option>
                                @foreach($cycles as $c)
                                    <option value="{{ $c }}" {{ request('cycle') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                            <select name="annee_scolaire" class="w-full rounded-md border border-gray-300 py-2">
                                <option value="">Toutes les années</option>
                                @foreach($annees_scolaires as $as)
                                    <option value="{{ $as }}" {{ request('annee_scolaire') == $as ? 'selected' : '' }}>{{ $as }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <button type="button" class="inline-flex items-center gap-1 px-3 py-1 text-sm border rounded-md hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                                Filtres avancés
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('page_boursiers') }}" class="inline-flex items-center px-3 py-1 text-sm border rounded-md hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                                    Réinitialiser
                                </a>
                                <a href="#" class="inline-flex items-center px-3 py-1 text-sm border rounded-md hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                    Exporter
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="rounded-lg border bg-white shadow-sm">
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-4 py-3 text-left font-medium">Nom</th>
                                    <th class="px-4 py-3 text-left font-medium">Prénom</th>
                                    <th class="px-4 py-3 text-left font-medium">Pays</th>
                                    <th class="px-4 py-3 text-left font-medium">Filière</th>
                                    <th class="px-4 py-3 text-left font-medium">Cycle</th>
                                    <th class="px-4 py-3 text-left font-medium">Établissement</th>
                                    <th class="px-4 py-3 text-left font-medium">Montant</th>
                                    <th class="px-4 py-3 text-left font-medium">Année scolaire</th>
                                    <th class="px-4 py-3 text-right font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($boursiers as $boursier)
                                <tr class="border-b">
                                    <td class="px-4 py-3 font-medium">{{ $boursier->NOM }}</td>
                                    <td class="px-4 py-3">{{ $boursier->PRENOMS }}</td>
                                    <td class="px-4 py-3">{{ $boursier->PAYS }}</td>
                                    <td class="px-4 py-3">{{ $boursier->FILIERE_A_FAIRE_RENSEIGNE }}</td>
                                    <td class="px-4 py-3">{{ $boursier->CYCLE_FORMATION_A_FAIRE }}</td>
                                    <td class="px-4 py-3">{{ $boursier->ETABLISSEMENT_ACCUEIL }}</td>
                                    <td class="px-4 py-3">{{ $boursier->MONT_BOURSE}} </td>
                                    <td class="px-4 py-3">{{ $boursier->ANNEE_SCOLAIRE }}</td>
                                    <td class="px-4 py-3 text-right">
                                     
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-3 text-center text-gray-500">Aucun boursier trouvé</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $boursiers->appends(request()->query())->links() }}
            </div>
        </div>
    </main>

</div>
@endsection