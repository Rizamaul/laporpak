@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-6">
    <a href="{{ route('tickets.index') }}" class="text-blue-600 hover:underline mb-4 inline-flex items-center gap-1">
        &larr; Kembali ke Daftar
    </a>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        
        <div class="p-6 border-b bg-gray-50 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $ticket->title }}</h1>
                <p class="text-gray-600 text-sm mt-2">
                    Dilaporkan oleh <strong class="text-gray-900">{{ $ticket->user->name }}</strong> 
                    <span class="mx-2">•</span> 
                    {{ $ticket->created_at->format('d M Y, H:i') }}
                </p>
                <span class="inline-block mt-3 bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-semibold">
                    Divisi: {{ $ticket->category->name }}
                </span>
            </div>
            
            @php
                $statusColor = match($ticket->status) {
                    'pending' => 'bg-red-100 text-red-800 border-red-200',
                    'in_progress' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'resolved' => 'bg-green-100 text-green-800 border-green-200',
                };
            @endphp
            <div class="text-right">
                <span class="px-4 py-2 rounded-full font-bold uppercase text-xs border {{ $statusColor }}">
                    {{ str_replace('_', ' ', $ticket->status) }}
                </span>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div>
                    <h3 class="font-bold text-gray-700 mb-2 flex items-center gap-2">
                        📍 Lokasi Kejadian
                    </h3>
                    <p class="text-gray-800 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        {{ $ticket->location }}
                    </p>
                </div>

                <div>
                    <h3 class="font-bold text-gray-700 mb-2 flex items-center gap-2">
                        📄 Deskripsi Masalah
                    </h3>
                    <p class="text-gray-800 whitespace-pre-line leading-relaxed text-justify">
                        {{ $ticket->description }}
                    </p>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-gray-700 mb-3 flex items-center gap-2">
                    📷 Bukti Foto
                </h3>
                @if($ticket->image_path)
                    <div class="border rounded-lg p-2 shadow-sm hover:shadow-md transition">
                        <img src="{{ asset('storage/' . $ticket->image_path) }}" 
                             alt="Bukti Foto" 
                             class="w-full h-64 object-cover rounded-md cursor-pointer hover:opacity-90 transition">
                        <p class="text-xs text-center text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                    </div>
                @else
                    <div class="bg-gray-100 h-64 flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 text-gray-400">
                        <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="italic text-sm">Tidak ada foto dilampirkan</span>
                    </div>
                @endif
            </div>
        </div>

        @if(auth()->user()->is_admin)
        <div class="bg-blue-50 p-6 border-t border-blue-100 mt-4">
            <h3 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                🛠 Admin Control Panel
            </h3>
            <form action="{{ route('tickets.updateStatus', $ticket) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4 bg-white p-4 rounded-lg shadow-sm border border-blue-100">
                @csrf
                @method('PATCH')
                <div class="flex-1 w-full">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Ubah Status Tiket</label>
                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                        <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>⏳ Pending (Menunggu)</option>
                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>⚙️ In Progress (Sedang Dikerjakan)</option>
                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>✅ Resolved (Selesai)</option>
                    </select>
                </div>
                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-md font-bold shadow transition transform hover:scale-105">
                    Update Status
                </button>
            </form>
        </div>
        @endif
    </div>

    <div class="mt-8 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden mb-12">
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                💬 Diskusi & Tanggapan
            </h3>
        </div>

        <div class="p-6">
            <div class="space-y-6 mb-8 max-h-[500px] overflow-y-auto pr-2">
                @forelse($ticket->comments as $comment)
                    <div class="flex gap-4 {{ $comment->user->is_admin ? 'flex-row-reverse' : '' }}">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shrink-0 shadow-sm {{ $comment->user->is_admin ? 'bg-blue-600' : 'bg-gray-500' }}">
                            {{ substr($comment->user->name, 0, 1) }}
                        </div>
                        
                        <div class="max-w-[80%] p-4 rounded-2xl shadow-sm relative {{ $comment->user->is_admin ? 'bg-blue-50 border border-blue-100 rounded-tr-none' : 'bg-gray-50 border border-gray-100 rounded-tl-none' }}">
                            <div class="flex justify-between items-center mb-2 gap-8">
                                <span class="font-bold text-sm {{ $comment->user->is_admin ? 'text-blue-800' : 'text-gray-800' }}">
                                    {{ $comment->user->name }}
                                    @if($comment->user->is_admin)
                                        <span class="bg-blue-200 text-blue-800 text-[10px] px-1.5 py-0.5 rounded ml-1">ADMIN</span>
                                    @endif
                                </span>
                                <span class="text-[10px] text-gray-400 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->message }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-400 italic">Belum ada tanggapan. Jadilah yang pertama berkomentar!</p>
                    </div>
                @endforelse
            </div>

            <form action="{{ route('comments.store', $ticket) }}" method="POST" class="relative">
                @csrf
                <div class="relative">
                    <textarea name="message" rows="3" class="w-full border border-gray-300 rounded-xl p-4 pr-32 focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none" placeholder="Tulis tanggapan atau pertanyaan..." required></textarea>
                    <button type="submit" class="absolute bottom-3 right-3 bg-gray-900 hover:bg-black text-white px-5 py-2 rounded-lg text-sm font-bold shadow-md transition transform hover:scale-105 flex items-center gap-2">
                        Kirim ✈️
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection