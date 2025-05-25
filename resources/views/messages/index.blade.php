@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Mes Conversations</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('messages.create.individual') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        💬 Message individuel
                    </a>
                    <a href="{{ route('messages.create.group') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        👥 Message de groupe
                    </a>
                </div>
            </div>
        </div>

        <!-- Liste des conversations -->
        <div class="divide-y divide-gray-200">
            @forelse($conversations as $conversation)
                <a href="{{ route('messages.show', $conversation) }}" 
                   class="block px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                @if($conversation->type === 'group')
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                        <span class="text-green-600 font-semibold">👥</span>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold">💬</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $conversation->display_name }}
                                </p>
                                @if($conversation->latestMessage->first())
                                    <p class="text-sm text-gray-500 truncate">
                                        <span class="font-medium">{{ $conversation->latestMessage->first()->sender->name }}:</span>
                                        {{ Str::limit($conversation->latestMessage->first()->content, 50) }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-500">Aucun message</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-1">
                            @if($conversation->latestMessage->first())
                                <span class="text-xs text-gray-400">
                                    {{ $conversation->latestMessage->first()->created_at->diffForHumans() }}
                                </span>
                            @endif
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $conversation->type === 'group' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $conversation->type === 'group' ? 'Groupe' : 'Individuel' }}
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="px-6 py-12 text-center">
                    <div class="text-gray-400 text-6xl mb-4">💬</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune conversation</h3>
                    <p class="text-gray-500 mb-6">Commencez une nouvelle conversation pour échanger avec vos collègues.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="{{ route('messages.create.individual') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Nouveau message individuel
                        </a>
                        <a href="{{ route('messages.create.group') }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Nouveau message de groupe
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
