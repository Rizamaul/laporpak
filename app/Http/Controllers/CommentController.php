<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate(['message' => 'required']);

     
        $ticket->comments()->create([
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);

        return back()->with('success', 'Komentar terkirim.');
    }
}