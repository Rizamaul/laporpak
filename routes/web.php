<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;   
use App\Http\Controllers\CommentController;  

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return redirect()->route('tickets.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    Route::resource('tickets', TicketController::class);
    
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])
        ->middleware('is_admin') 
        ->name('tickets.updateStatus');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';