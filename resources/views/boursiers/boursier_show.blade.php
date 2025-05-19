@extends('layouts.app')

@php
use Carbon\Carbon;
@endphp

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-xl transform hover:scale-105 transition duration-300">
  {{-- En-tête/Profile --}}
  <div class="flex items-center space-x-6 mb-8">
    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-purple-500 to-indigo-600 p-1">
      <img src="https://via.placeholder.com/150" alt="Photo boursier" class="rounded-full w-full h-full object-cover">
    </div>
    <div>
      <h1 class="text-3xl font-extrabold text-gray-800">{{ $boursier->NOM }} {{ $boursier->PRENOMS }}</h1>
      <p class="text-sm text-gray-500 uppercase tracking-wide">{{ $boursier->OBJET_DEMANDE }}</p>
    </div>
  </div>

  {{-- Grille d'informations --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Colonne Gauche --}}
    <div class="space-y-4">
      <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
        <h2 class="text-lg font-semibold text-gray-700">Informations Personnelles</h2>
        <ul class="mt-2 text-gray-600">
          <li><strong>Date de Naissance :</strong> {{ \Carbon\Carbon::parse($boursier->DATE_NAISSANCE)->format('d/m/Y') }}</li>
          <li><strong>Genre :</strong> {{ $boursier->SEXE ?? 'N/A' }}</li>
          <li><strong>Diplome :</strong> {{ $boursier->DIPLOME_EFFECTUE }}</li>
          <li><strong>Année Scolaire :</strong> {{ $boursier->ANNEE_SCOLAIRE }}</li>
        </ul>
      </div>
      <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
        <h2 class="text-lg font-semibold text-gray-700">Contact</h2>
        <ul class="mt-2 text-gray-600">
          <li><strong>Email :</strong> {{ $boursier->EMAIL ?? '—' }}</li>
          <li><strong>Téléphone :</strong> {{ $boursier->TELEPHONE ?? '—' }}</li>
        </ul>
      </div>
    </div>

    {{-- Colonne Droite --}}
    <div class="space-y-4">
      <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
        <h2 class="text-lg font-semibold text-gray-700">Détails Académiques</h2>
        <ul class="mt-2 text-gray-600">
          <li><strong>Pays :</strong> {{ $boursier->PAYS }}</li>
          <li><strong>Cycle :</strong> {{ $boursier->CYCLE_FORMATION_A_FAIRE }}</li>
          <li><strong>Établissement :</strong> {{ $boursier->ETABLISSEMENT_ACCUEIL }}</li>
          <li><strong>Filière :</strong> {{ $boursier->FILIERE_CHOISIE }}</li>
          <li><strong>Diplôme ensisagé :</strong> {{ $boursier->DIPLOME_A_FAIRE }}</li>
        </ul>
      </div>
      <div class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
        <h2 class="text-lg font-semibold text-gray-700">Financement</h2>
        <ul class="mt-2 text-gray-600">
          <li><strong>Montant Bourse :</strong> {{ $boursier->MONT_BOURSE }} FCFA</li>
          <li><strong>Assurance :</strong> {{ $boursier->MONTANT_ASSURANCE }} FCFA</li>
        </ul>
      </div>
    </div>
  </div>

  {{-- Bouton Retour --}}
  <div class="mt-8 text-center">
    <a href="{{ route('dashboard') }}" 
       class="inline-block px-6 py-3 bg-indigo-600 text-white font-semibold rounded-full shadow-md hover:bg-indigo-700 transition">
      <span class="inline-flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Retour au Dashboard
      </span>
    </a>
  </div>
</div>
@endsection
