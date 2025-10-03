<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::middleware(['ldap.auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    Route::get('profile', function () {
        return view('profile');
    })->name('profile');

    // Visitor routes
    Route::get('visitor/create', function () {
        return view('visitor-detail');
    })->name('visitor.create');

    Route::get('visitor/{visitor}', function (App\Models\SenseVisitor $visitor) {
        return view('visitor-detail', ['visitor' => $visitor]);
    })->name('visitor.detail');
});


require __DIR__.'/auth.php';
