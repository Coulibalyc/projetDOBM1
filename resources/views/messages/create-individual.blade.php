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
                    💬 Nouveau message individuel
                </h1>
            </div>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('messages.store.individual') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Sélection du destinataire -->
            <div>
                <label for="recipient_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Destinataire
                </label>
                <select name="recipient_id" id="recipient_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                    <option value="">Sélectionnez un destinataire</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('recipient_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('recipient_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Message
                </label>
                <textarea name="content" id="content" rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Tapez votre message..."
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
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium">
                    Envoyer le message
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
