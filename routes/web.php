<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\ProjectDetail;
use Illuminate\Support\Facades\Route;

// Redirect home
Route::redirect('/', '/dashboard');

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Project detail
    Route::get('/projects/{project}', ProjectDetail::class)
         ->name('project.detail');
});

// Profile routes
Route::middleware('auth')->group(function () {
    // General Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Password
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    
    // Danger Zone
    Route::get('/profile/danger', [ProfileController::class, 'editDangerZone'])->name('profile.danger');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes
require __DIR__.'/auth.php';