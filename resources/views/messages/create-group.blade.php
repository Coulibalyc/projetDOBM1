@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <a href="{{ route('messages.index') }}" 
                   class="text-gray-400 hover:text-gray-600">
                    ← Retour
                </a>
                <h1 class="text-xl font-semibold text-gray-900">
                    👥 Nouveau message de groupe
                </h1>
            </div>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('messages.store.group') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Titre du groupe -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre du groupe
                </label>
                <input type="text" name="title" id="title" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                       placeholder="Ex: Équipe Marketing, Projet X..."
                       value="{{ old('title') }}"
                       required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sélection des participants -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Participants
                </label>
                <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-300 rounded-md p-3">
                    @foreach($users as $user)
                        <label class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded">
                            <input type="checkbox" name="participants[]" value="{{ $user->id }}"
                                   class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                   {{ in_array($user->id, old('participants', [])) ? 'checked' : '' }}>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('participants')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('participants.*')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message initial -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Message initial
                </label>
                <textarea name="content" id="content" rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                          placeholder="Tapez votre message initial pour le groupe..."
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('messages.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium">
                    Créer le groupe
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
