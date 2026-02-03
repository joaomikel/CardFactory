<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Api\ListingController;
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

Route::get('/dashboard', function () {
    $listings = Auth::user()->listings()->with('card.set')->latest()->get();  
    $sets = Set::orderBy('name', 'asc')->get();

    return view('dashboard', [
        'listings' => $listings, 
        'sets' => $sets
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalogo');

Route::get('/colecciones', function () {
    return view('colecciones');
});

Route::get('/carrito', function () {
    return view('carrito');
});

Route::get('/carta', [App\Http\Controllers\CatalogController::class, 'showCard'])->name('carta.show');



// --- ZONA DE VENTAS ---

// 1. MODIFICADO: Enviamos los sets a la vista
Route::get('/vender', function () {
    // Obtenemos los sets ordenados alfabéticamente
    $sets = Set::orderBy('name', 'asc')->get(); 
    return view('vender', compact('sets'));
})->middleware(['auth'])->name('vender');

Route::middleware(['auth'])->group(function () {
    Route::put('/listings/{id}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{id}', [ListingController::class, 'destroy'])->name('listings.destroy');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');

});

require __DIR__.'/auth.php';