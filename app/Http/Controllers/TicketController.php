<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class TicketController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            $tickets = Ticket::with('user', 'category')->latest()->get();
        } else {
            $tickets = Ticket::where('user_id', auth()->id())
                           ->with('category')
                           ->latest()
                           ->get();
        }
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'location' => 'required',
            'image' => 'required|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('tickets', 'public');
        }

        Ticket::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'image_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Laporan berhasil dibuat!');
    }

    public function show(Ticket $ticket)
    {
        if (!auth()->user()->is_admin && $ticket->user_id !== auth()->id()) {
            abort(403);
        }
        return view('tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $ticket->update(['status' => $request->status]);
        return back()->with('success', 'Status diperbarui!');
    }
}