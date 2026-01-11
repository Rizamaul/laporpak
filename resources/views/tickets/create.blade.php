@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">📝 Buat Laporan Baru</h2>

    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Judul Keluhan</label>
            <input type="text" name="title" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" placeholder="Contoh: AC di Ruang 304 Bocor" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Divisi Tujuan</label>
            <select name="category_id" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Lokasi Kejadian</label>
            <input type="text" name="location" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" placeholder="Gedung, Lantai, atau Ruangan" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Deskripsi Detail</label>
            <textarea name="description" rows="5" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-200" placeholder="Jelaskan masalahnya secara rinci..." required></textarea>
        </div>

        <div class="mb-6 bg-blue-50 p-4 rounded border border-blue-100">
            <label class="block text-gray-700 font-bold mb-2">Bukti Foto (Wajib)</label>
            <input type="file" name="image" class="w-full text-sm text-slate-500
              file:mr-4 file:py-2 file:px-4
              file:rounded-full file:border-0
              file:text-sm file:font-semibold
              file:bg-blue-600 file:text-white
              hover:file:bg-blue-700" accept="image/*" required>
            <p class="text-xs text-gray-500 mt-1">*Maksimal 2MB, Format JPG/PNG</p>
        </div>

        <div class="flex gap-4">
            <a href="{{ route('tickets.index') }}" class="w-1/3 text-center border border-gray-300 text-gray-700 py-2 rounded hover:bg-gray-100">Batal</a>
            <button type="submit" class="w-2/3 bg-blue-600 text-white font-bold py-2 rounded hover:bg-blue-700 transition">
                Kirim Laporan 🚀
            </button>
        </div>
    </form>
</div>
@endsection