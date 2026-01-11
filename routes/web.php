<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;   // Pastikan ini ada
use App\Http\Controllers\CommentController;  // Pastikan ini ada

Route::get('/', function () {
    return view('welcome');
});

// --- BAGIAN INI YANG MENYEBABKAN ERROR TADI ---
// Kita arahkan dashboard langsung ke tickets.index
// Tapi rutenya harus didefinisikan di bawahnya dulu
Route::get('/dashboard', function () {
    return redirect()->route('tickets.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- GRUP ROUTE UNTUK APLIKASI LAPOR PAK ---
Route::middleware(['auth'])->group(function () {
    
    // Baris inilah yang menciptakan nama 'tickets.index'
    Route::resource('tickets', TicketController::class);
    
    // Route untuk Komentar
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');

    // Route Admin (Ganti Status)
    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])
        ->middleware('is_admin') 
        ->name('tickets.updateStatus');

    // Route Profile bawaan Breeze (Opsional, biar tidak error jika diakses)
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ROUTE BAWAAN AUTH (LOGIN/REGISTER) ---
require __DIR__.'/auth.php';