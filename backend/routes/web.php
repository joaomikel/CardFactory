<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    // 1. Obtenemos las ventas del usuario
    // Usamos 'with' para cargar también los datos de la carta (nombre, imagen...)
    $listings = Auth::user()->listings()->with('card')->latest()->get();

    // 2. Pasamos la variable $listings a la vista
    return view('dashboard', ['listings' => $listings]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/catalogo', function () {
    return view('catalogo');
});

Route::get('/colecciones', function () {
    return view('colecciones');
});

Route::get('/carrito', function () {
    return view('carrito');
});

Route::get('/carta', function () {
    return view('carta');
});

require __DIR__.'/auth.php';
