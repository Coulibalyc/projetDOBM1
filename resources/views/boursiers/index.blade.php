<!-- resources/views/boursiers/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10">
  <div class="container py-6 px-4 -mt-20 -ml-4">
    <h2 class="mb-2 text-3xl font-bold text-indigo-700">Tableau de bord</h2>
  </div>

  <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
    <!-- Carte 1: Total Boursiers -->
    <div class="rounded-lg border border-indigo-200 bg-indigo-50 p-6 shadow-lg">
      <div class="flex items-center justify-between pb-2">
        <h3 class="text-sm font-medium text-indigo-600">Total Boursiers</h3>
        <!-- Icône utilisateurs (Heroicons) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
          <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
        </svg>
      </div>
      <div class="mt-2">
        <div class="text-2xl font-bold text-indigo-800">
          {{ number_format($stats['total'], 0, ',', ' ') }}
        </div>
        <p class="text-xs text-indigo-600">
          @if(isset($stats['totalFiltre']))
            {{ $stats['totalFiltre'] }} résultats filtrés
          @else
            +12% par rapport à l'année précédente
          @endif
        </p>
      </div>
    </div>

    <!-- Carte 2: Pays d'Accueil -->
    <div class="rounded-lg border border-pink-200 bg-pink-50 p-6 shadow-lg">
      <div class="flex items-center justify-between pb-2">
        <h3 class="text-sm font-medium text-pink-600">Pays d'Accueil</h3>
        <!-- Icône globe (Heroicons) -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-400" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="mt-2">
        <div class="text-2xl font-bold text-pink-800">
          {{ $stats['parPays']->count() }}
        </div>
        <p class="text-xs text-pink-600">
          @if($stats['parPays']->count() > 0)
            Top pays: {{ $stats['parPays'][0]->pays }} ({{ $stats['parPays'][0]->count }})
          @else
            +3 nouveaux pays cette année
          @endif
        </p>
      </div>
    </div>

    <!-- Carte 3: Répartition par Cycle -->
    <div class="rounded-lg border border-green-200 bg-green-50 p-6 shadow-lg">
      <div class="flex items-center justify-between pb-2">
        <h3 class="text-sm font-medium text-green-600">Cycles d'études</h3>
        <!-- Icône éducation -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
          <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
        </svg>
      </div>
      <div class="mt-2">
        <div class="text-2xl font-bold text-green-800">
          {{ $stats['parCycle']->count() }}
        </div>
        <p class="text-xs text-green-600">
          @if($stats['parCycle']->count() > 0)
            Principal: {{ $stats['parCycle'][0]->cycle_formation_a_faire }}
          @else
            Aucun cycle enregistré
          @endif
        </p>
      </div>
    </div>

    <!-- Carte 4: Statuts -->
    <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-6 shadow-lg">
      <div class="flex items-center justify-between pb-2">
        <h3 class="text-sm font-medium text-yellow-600">Statuts</h3>
        <!-- Icône statut -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd" />
        </svg>
      </div>
      <div class="mt-2">
        <div class="text-2xl font-bold text-yellow-800">
          {{ $stats['parStatut']->count() }}
        </div>
        <p class="text-xs text-yellow-600">
          @if($stats['parStatut']->count() > 0)
            Principaux statuts
          @else
            Aucun statut enregistré
          @endif
        </p>
      </div>
    </div>
  </div>

  <div class="grid gap-6 md:grid-cols-2 mt-6">
    <!-- Carte Répartition par Pays -->
    <div class="rounded-lg border border-purple-200 bg-purple-50 p-6 shadow-lg">
      <div class="mb-4">
        <h3 class="text-lg font-medium text-purple-700">Répartition par Pays</h3>
        <p class="text-sm text-purple-600">Tous les pays d'accueil ({{ $stats['parPays']->count() }} pays)</p>
      </div>
      <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2">
        @foreach($stats['parPays'] as $pays)
          @php
            $percentage = round(($pays->count / $stats['total']) * 100);
          @endphp
          <div class="flex items-center py-1">
            <div class="w-40 text-sm font-medium truncate text-purple-800">{{ $pays->pays }}</div>
            <div class="flex-1 mx-2">
              <div class="h-2 w-full rounded-full bg-purple-200">
                <div class="h-2 rounded-full bg-purple-500" style="width: {{ $percentage }}%"></div>
              </div>
            </div>
            <div class="w-12 text-right text-sm font-medium text-purple-800">
              {{ $percentage }}%
              <span class="block text-xs text-purple-500">({{ $pays->count }})</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Nouvelle Carte Répartition par Filière -->
    <div class="rounded-lg border border-teal-200 bg-teal-50 p-6 shadow-lg">
      <div class="mb-4">
        <h3 class="text-lg font-medium text-teal-700">Répartition par niveau</h3>
        <p class="text-sm text-teal-600">Distribution par domaine d'étude</p>
      </div>
      <div class="space-y-2 max-h-[400px] overflow-y-auto">
        @foreach($stats['parFiliere'] as $filiere)
          @php
            $percentage = round(($filiere->count / $stats['total']) * 100);
          @endphp
          <div class="flex items-center py-1">
            <div class="w-40 text-sm font-medium truncate text-teal-800" title="{{ $filiere->diplome_a_faire }}">
              {{ $filiere->diplome_a_faire }}
            </div>
            <div class="flex-1 mx-2">
              <div class="h-2 w-full rounded-full bg-teal-200">
                <div class="h-2 rounded-full bg-teal-500" style="width: {{ $percentage }}%"></div>
              </div>
            </div>
            <div class="w-12 text-right text-sm font-medium text-teal-800">
              {{ $percentage }}%
              <span class="block text-xs text-teal-500">({{ $filiere->count }})</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="mt-6">
    <div class="rounded-lg border border-red-200 bg-red-50 p-6 shadow-lg">
      <div class="mb-4">
        <h3 class="text-lg font-medium text-red-700">Liste des boursiers</h3>
        <p class="text-sm text-red-600">Liste des derniers boursiers ajoutés</p>
      </div>
      
      <div class="overflow-x-auto shadow rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-3 text-left font-semibold text-red-700">Nom Complet</th>
              <th class="px-4 py-3 text-left font-semibold text-red-700">Pays</th>
              <th class="px-4 py-3 text-left font-semibold text-red-700">Filière</th>
              <th class="px-4 py-3 text-left font-semibold text-red-700">Cycle</th>
              <th class="px-4 py-3 text-left font-semibold text-red-700">Statut</th>
              <th class="px-4 py-3 text-left font-semibold text-red-700">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($stats['recentBoursiers'] as $boursier)
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3 whitespace-nowrap">
                {{ $boursier->NOM }} {{ $boursier->PRENOMS }}
              </td>
              <td class="px-4 py-3 whitespace-nowrap">
                {{ $boursier->PAYS }}
              </td>
              <td class="px-4 py-3 whitespace-nowrap">
                {{ $boursier->FILIERE_A_FAIRE_RENSEIGNE }}
              </td>
              <td class="px-4 py-3 whitespace-nowrap">
                {{ $boursier->CYCLE_FORMATION_A_FAIRE }}
              </td>
              <td class="px-4 py-3 whitespace-nowrap">
                @if($boursier->decision == 'accepté')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Actif
                  </span>
                @elseif($boursier->decision == 'en attente')
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    En attente
                  </span>
                @else
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    ATTRIBUTION_BOURSE
                  </span>
                @endif
              </td>
              <td class="px-4 py-3 whitespace-nowrap">
                <a href="{{ route('boursiers.show', $boursier->IDUS) }}" class="text-blue-600 hover:text-blue-900 hover:underline">
                  Détails
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
      <div class="mt-4 flex justify-end">
        <a href="{{ route('page_boursiers') }}" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
          Voir tous les boursiers
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
