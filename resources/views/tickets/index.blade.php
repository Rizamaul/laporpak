@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Daftar Laporan</h1>
    <a href="{{ route('tickets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
        + Buat Laporan Baru
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($tickets as $ticket)
    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 overflow-hidden border border-gray-200">
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                    {{ $ticket->category->name }}
                </span>
                @php
                    $statusClass = match($ticket->status) {
                        'pending' => 'bg-red-100 text-red-800',
                        'in_progress' => 'bg-yellow-100 text-yellow-800',
                        'resolved' => 'bg-green-100 text-green-800',
                    };
                @endphp
                <span class="{{ $statusClass }} text-xs font-bold px-2.5 py-0.5 rounded uppercase">
                    {{ str_replace('_', ' ', $ticket->status) }}
                </span>
            </div>

            <h3 class="text-xl font-bold mb-2 text-gray-900 truncate">{{ $ticket->title }}</h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $ticket->description }}</p>
            
            <div class="flex justify-between items-center text-xs text-gray-500 border-t pt-4">
                <span>📍 {{ Str::limit($ticket->location, 20) }}</span>
                <span>👤 {{ $ticket->user->name }}</span>
            </div>
            
            <a href="{{ route('tickets.show', $ticket) }}" class="block mt-4 text-center text-blue-600 font-semibold hover:bg-blue-50 py-2 rounded border border-blue-200 transition">
                Lihat Detail &rarr;
            </a>
        </div>
    </div>
    @endforeach
</div>

@if($tickets->isEmpty())
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg">Belum ada laporan yang masuk.</p>
    </div>
@endif
@endsection