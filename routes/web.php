<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\AdminDashboard;
use App\Livewire\MyTasks;
use App\Livewire\ProjectDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect root based on role
Route::get('/', function () {
    if (Auth::check() && Auth::user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('dashboard');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Smart Dashboard Redirection
    Route::get('/dashboard', function () {
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // User Features
    Route::get('/my-tasks', MyTasks::class)->name('my-tasks');
    Route::get('/projects/{project}', ProjectDetail::class)->name('project.detail');
    
    // Admin Exclusive
    Route::get('/admin', AdminDashboard::class)->name('admin.dashboard');
});

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::get('/profile/danger', [ProfileController::class, 'editDangerZone'])->name('profile.danger');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';