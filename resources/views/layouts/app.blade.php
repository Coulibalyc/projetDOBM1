<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plateforme Boursiers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 text-gray-800">

<header class="sticky top-0 z-10 border-b bg-white">
    <div class="container mx-auto flex h-16 items-center justify-between px-4 py-4">
        <div class="flex items-center gap-2">
         <img src="{{ asset('images/logo.png') }}" alt="image" class="w-24 mt-2">
            <h1 class="text-xl font-bold">Gestion des Boursiers</h1>
        </div>
        <nav class="flex items-center gap-4">
            <a href="/" class="text-sm font-medium hover:underline">
                Tableau de bord
            </a>
            <a href="/boursiers" class="text-sm font-medium hover:underline">
                Boursiers
            </a>
            <a href="/statistiques" class="text-sm font-medium hover:underline">
                Statistiques
            </a>
            <button class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Se déconnecter
            </button>
        </nav>
    </div>
</header>

    <main class="py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

<!-- Footer -->
<footer class="border-t bg-[#011f31] mt-8">
  <div class="container mx-auto px-4 py-4">
    <p class="text-sm text-gray-500">© {{ date('Y') }} DOBM - Gestion des Boursiers. Tous droits réservés.</p>
  </div>
</footer>

</body>
</html>
