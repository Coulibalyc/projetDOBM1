@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <!-- Header de la conversation -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('messages.index') }}" 
                       class="text-gray-400 hover:text-gray-600">
                        ← Retour
                    </a>
                    <div class="flex items-center space-x-2">
                        @if($conversation->type === 'group')
                            <span class="text-green-600">👥</span>
                        @else
                            <span class="text-blue-600">💬</span>
                        @endif
                        <h1 class="text-xl font-semibold text-gray-900">
                            {{ $conversation->display_name }}
                        </h1>
                    </div>
                </div>
                <div class="text-sm text-gray-500">
                    {{ $conversation->participants->count() }} participant(s)
                </div>
            </div>
        </div>

        <!-- Zone des messages -->
        <div class="h-96 overflow-y-auto p-6 space-y-4" id="messages-container">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md">
                        @if($message->sender_id !== Auth::id())
                            <div class="text-xs text-gray-500 mb-1">
                                {{ $message->sender->name }}
                            </div>
                        @endif
                        <div class="px-4 py-2 rounded-lg {{ $message->sender_id === Auth::id() 
                            ? 'bg-blue-600 text-white' 
                            : 'bg-gray-200 text-gray-900' }}">
                            <p class="text-sm">{{ $message->content }}</p>
                        </div>
                        <div class="text-xs text-gray-400 mt-1 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}">
                            {{ $message->created_at->format('H:i') }}
                            @if($message->sender_id === Auth::id() && $message->read_at)
                                <span class="text-blue-500">✓</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <div class="text-4xl mb-2">💬</div>
                    <p>Aucun message dans cette conversation</p>
                    <p class="text-sm">Soyez le premier à envoyer un message !</p>
                </div>
            @endforelse
        </div>

        <!-- Formulaire d'envoi de message -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <form action="{{ route('messages.store', $conversation) }}" method="POST" class="flex space-x-3">
                @csrf
                <div class="flex-1">
                    <textarea name="content" 
                              rows="2" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                              placeholder="Tapez votre message..."
                              required></textarea>
                    @error('content')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium self-end">
                    Envoyer
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-scroll vers le bas des messages
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
    });
</script>
@endsection
