<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextEntry;

class TextContentController extends Controller
{

    public function show(Request $request)
    {
        $entries = TextEntry::with('user:id,username')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($entry) {
                return [
                    'id' => $entry->id,
                    'text' => $entry->text,
                    'written_by' => $entry->user->username,
                    'created_at' => $entry->created_at->toIso8601String()
                ];
            });
        
        return response()->json([
            'entries' => $entries,
            'role' => $request->user()->role,
            'can_edit' => $request->user()->role === 'writer'
        ], 200);
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:10000'
        ]);

        // Create new entry (not overwrite)
        $entry = TextEntry::create([
            'text' => $validated['text'],
            'user_id' => $request->user()->id
        ]);

        return response()->json([
            'message' => 'Text entry added successfully',
            'entry' => [
                'id' => $entry->id,
                'text' => $entry->text,
                'written_by' => $request->user()->username,
                'created_at' => $entry->created_at->toIso8601String()
            ]
        ], 201);
    }
}