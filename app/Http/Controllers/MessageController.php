<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController
{
    public function index()
    {
        $conversations = Auth::user()->conversations()
            ->with(['latestMessage.sender', 'participants'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // Vérifier que l'utilisateur fait partie de la conversation
        if (!$conversation->participants->contains(Auth::id())) {
            abort(403);
        }

        $messages = $conversation->messages()->with('sender')->get();
        
        // Marquer les messages comme lus
        $conversation->messages()
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.show', compact('conversation', 'messages'));
    }

    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Vérifier que l'utilisateur fait partie de la conversation
        if (!$conversation->participants->contains(Auth::id())) {
            abort(403);
        }

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $request->content,
            'type' => 'text'
        ]);

        // Mettre à jour le timestamp de la conversation
        $conversation->touch();

        return redirect()->route('messages.show', $conversation)
                        ->with('success', 'Message envoyé avec succès');
    }

    public function createIndividual()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.create-individual', compact('users'));
    }

    public function storeIndividual(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id|different:' . Auth::id(),
            'content' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($request) {
            // Vérifier s'il existe déjà une conversation entre ces deux utilisateurs
            $existingConversation = Conversation::where('type', 'individual')
                ->whereHas('participants', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->whereHas('participants', function ($query) use ($request) {
                    $query->where('user_id', $request->recipient_id);
                })
                ->first();

            if ($existingConversation) {
                $conversation = $existingConversation;
            } else {
                // Créer une nouvelle conversation
                $conversation = Conversation::create([
                    'type' => 'individual',
                    'created_by' => Auth::id()
                ]);

                // Ajouter les participants
                $conversation->participants()->attach([
                    Auth::id() => ['joined_at' => now()],
                    $request->recipient_id => ['joined_at' => now()]
                ]);
            }

            // Créer le message
            $conversation->messages()->create([
                'sender_id' => Auth::id(),
                'content' => $request->content,
                'type' => 'text'
            ]);

            $conversation->touch();
        });

        return redirect()->route('messages.index')
                        ->with('success', 'Message envoyé avec succès');
    }

    public function createGroup()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.create-group', compact('users'));
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'participants' => 'required|array|min:1',
            'participants.*' => 'exists:users,id|different:' . Auth::id(),
            'content' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($request) {
            // Créer la conversation de groupe
            $conversation = Conversation::create([
                'title' => $request->title,
                'type' => 'group',
                'created_by' => Auth::id()
            ]);

            // Ajouter le créateur et les participants
            $participants = collect($request->participants)->push(Auth::id())->unique();
            $participantData = $participants->mapWithKeys(function ($userId) {
                return [$userId => ['joined_at' => now()]];
            })->toArray();

            $conversation->participants()->attach($participantData);

            // Créer le message initial
            $conversation->messages()->create([
                'sender_id' => Auth::id(),
                'content' => $request->content,
                'type' => 'text'
            ]);
        });

        return redirect()->route('messages.index')
                        ->with('success', 'Conversation de groupe créée avec succès');
    }
}
