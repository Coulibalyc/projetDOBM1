<nav x-data="{ open: false }"
     class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-10 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Logo + titre --}}
            <div class="flex items-center space-x-2">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-16 h-auto md:w-24">
                </a>
                <a href="{{ route('dashboard') }}"
                   class="text-lg md:text-xl font-bold text-gray-800 dark:text-gray-200">
                    Gestion des Boursiers
                </a>
            </div>

            {{-- Liens de navigation (desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <x-nav-link href="/" :active="request()->is('/')">
                    Tableau de bord
                </x-nav-link>
                <x-nav-link href="/boursiers" :active="request()->is('boursiers*')">
                    Boursiers
                </x-nav-link>
                <x-nav-link href="#" :active="request()->is('statistiques*')">
                    Statistiques
                </x-nav-link>
                <x-nav-link href="/messages" :active="request()->is('Messagerie*')">
                    Messagerie
                </x-nav-link>
            </div>

            {{-- Dropdown utilisateur (desktop) --}}
            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md
                                       text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800
                                       hover:text-gray-700 dark:hover:text-gray-300
                                       focus:outline-none transition ease-in-out duration-150">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ms-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                                             111.414 1.414l-4 4a1 1 0 01-1.414 
                                             0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Se déconnecter') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            {{-- Hamburger mobile --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500
                               hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900
                               focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500
                               transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu responsive (mobile) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200 dark:border-gray-600">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/" :active="request()->is('/')">
                Tableau de bord
            </x-responsive-nav-link>
            <x-responsive-nav-link href="/boursiers" :active="request()->is('boursiers*')">
                Boursiers
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="request()->is('statistiques*')">
                Statistiques
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#" :active="request()->is('statistiques*')">
                Messagerie
            </x-responsive-nav-link>
        </div>

        {{-- Options utilisateur mobile --}}
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Se déconnecter') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
