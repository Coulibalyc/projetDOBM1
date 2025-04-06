<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOBM - Gestion des Boursiers</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-gray-50">
    <!-- Header -->
    <header class="sticky top-0 z-10 border-b bg-white">
        <div class="container flex h-16 items-center justify-between px-4 py-4">
            <div class="flex items-center gap-2">
                <h1 class="text-xl font-bold">DOBM - Gestion des Boursiers</h1>
            </div>
            <nav class="flex items-center gap-4">
                <a href="{{ route('boursiers.index') }}" class="text-sm font-medium hover:underline">Tableau de bord</a>
                <a href="{{ route('page_boursiers') }}" class="text-sm font-medium hover:underline">Boursiers</a>
            
                

            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">


            <!-- Filtres Card -->
            <div class="mb-6 rounded-lg border bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-medium">Filtres</h3>
                <form method="GET" action="{{ route('boursiers.index') }}">
                    <div class="grid gap-4 md:grid-cols-4">
                        <!-- Recherche -->
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2.5 top-2.5 h-3 w-3 text-gray-400 " viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Rechercher..." 
                                class="w-full rounded-md border border-gray-300 py-2 pl-8 pr-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500" 
                                value="{{ request('search') }}"
                            >
                        </div>

                        <!-- Pays Select -->
                        <select name="pays" class="rounded-md border border-gray-300 py-2 pl-3 pr-8 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                            <option value="">Tous les pays</option>
                            @foreach($countries as $country)
                                <option value="{{ $country }}" {{ request('pays') == $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>

                        <!-- Cycle Select -->
                        <select name="cycle" class="rounded-md border border-gray-300 py-2 pl-3 pr-8 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                            <option value="">Tous les cycles</option>
                            <option value="Licence" {{ request('cycle') == 'Licence' ? 'selected' : '' }}>Licence</option>
                            <option value="Master" {{ request('cycle') == 'Master' ? 'selected' : '' }}>Master</option>
                            <option value="Doctorat" {{ request('cycle') == 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                        </select>

                        <!-- Année Scolaire Select -->
                        <select name="annee" class="rounded-md border border-gray-300 py-2 pl-3 pr-8 text-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500">
                            <option value="">Toutes les années</option>
                            @foreach($schoolYears as $year)
                                <option value="{{ $year }}" {{ request('annee') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <button type="button" class="inline-flex items-center gap-1 rounded-md border border-gray-300 px-3 py-1 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Filtres avancés
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('boursiers.index') }}" class="inline-flex items-center rounded-md border border-gray-300 px-3 py-1 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                </svg>
                                Réinitialiser
                            </a>
                            <button type="button" class="inline-flex items-center rounded-md border border-gray-300 px-3 py-1 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Exporter
                            </button>
                            <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                                Appliquer
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Card -->
     <div class="overflow-x-auto shadow rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
            <th class="px-4 py-3 text-left font-semibold text-red-700">Nom</th>
                   <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Prénom</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pays</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Filière</th>
                 <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Cycle</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Établissement</th>
                     <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Montant</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Année scolaire</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($boursiers as $boursier)
            <tr class="hover:bg-gray-50">
            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">{{ $boursier->NOM }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $boursier->PRENOMS }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $boursier->PAYS }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $boursier->FILIERE_A_FAIRE_RENSEIGNE }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $boursier->CYCLE_FORMATION_A_FAIRE }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $boursier->ETABLISSEMENT_ACCUEIL }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ number_format($boursier->MONT_BOURSE, 0, ',', ' ') }} €</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $boursier->ANNEE_SCOLAIRE }}</td>

            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $boursiers->links() }}
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t bg-gray-50">
        <div class="container mx-auto px-4 py-4">
            <p class="text-sm text-gray-500">© {{ date('Y') }} DOBM - Gestion des Boursiers. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>