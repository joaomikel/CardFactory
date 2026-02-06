<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\CheckoutController; 
use App\Models\Listing;
use App\Models\Card;
use App\Models\Set; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});

// Ruta Dashboard (Protegida con Auth y Log)
Route::get('/dashboard', function () {
    $listings = Auth::user()->listings()->with('card.set')->latest()->get();  
    $sets = Set::orderBy('name', 'asc')->get();

    return view('dashboard', [
        'listings' => $listings, 
        'sets' => $sets
    ]);
})->middleware(['auth', 'verified', 'log.activity'])->name('dashboard');

// Grupo de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalogo');

Route::get('/colecciones', function () {
    return view('colecciones');
});

// Ruta Carrito (Pública o Auth)
Route::get('/carrito', function () {
    return view('carrito');
});

Route::get('/carta', [App\Http\Controllers\CatalogController::class, 'showCard'])->name('carta.show');

// --- ZONA DE VENTAS ---
Route::get('/vender', function () {
    $sets = Set::orderBy('name', 'asc')->get(); 
    return view('vender', compact('sets'));
})->middleware(['auth'])->name('vender');

// Rutas de API interna para Listings
Route::middleware(['auth'])->group(function () {
    Route::put('/listings/{id}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{id}', [ListingController::class, 'destroy'])->name('listings.destroy');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
});

Route::middleware(['auth', 'log.activity'])->group(function () {
    Route::post('/pagar', [CheckoutController::class, 'process'])->name('pagar');

});

Route::view('/ayuda', 'ayuda');

require __DIR__.'/auth.php';