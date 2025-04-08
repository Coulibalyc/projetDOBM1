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
<body class="bg-blue-50 text-gray-800 flex flex-col min-h-screen">

<header class="sticky top-0 z-10 border-b bg-white shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="image" class="w-16 md:w-24">
                    <h1 class="text-lg md:text-xl font-bold">Gestion des Boursiers</h1>
                </div>
                <!-- Bouton menu mobile -->
                <button id="mobile-menu-button" class="md:hidden rounded-md p-2 text-gray-600 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            
            <nav id="mobile-menu" class="hidden md:flex flex-col md:flex-row md:items-center gap-4 mt-4 md:mt-0">
                <a href="/" class="py-2 md:py-0 text-sm font-medium hover:text-blue-600 hover:underline">
                    Tableau de bord
                </a>
                <a href="/boursiers" class="py-2 md:py-0 text-sm font-medium hover:text-blue-600 hover:underline">
                    Boursiers
                </a>
                <a href="/statistiques" class="py-2 md:py-0 text-sm font-medium hover:text-blue-600 hover:underline">
                    Statistiques
                </a>
                <button class="mt-2 md:mt-0 inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1 text-sm font-medium shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Se déconnecter
                </button>
            </nav>
        </div>
    </div>
</header>

<main class="flex-grow py-6 px-4 sm:px-6 lg:px-8">
    @yield('content')
</main>

<!-- Footer -->
<footer class="border-t bg-[#011f31] mt-auto">
    <div class="container mx-auto px-4 py-4">
        <p class="text-sm text-white">© {{ date('Y') }} DOBM - Gestion des Boursiers. Tous droits réservés.</p>
    </div>
</footer>

<!-- Script pour le menu mobile -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Fermer le menu si on clique en dehors
        document.addEventListener('click', function(event) {
            if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
        
        // Ajuster la visibilité du menu en fonction de la taille de l'écran
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) { // 768px est le breakpoint md de Tailwind
                mobileMenu.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
            }
        });
    });
</script>

</body>
</html>