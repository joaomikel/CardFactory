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

// 2. MODIFICADO: Recibimos el set_id y guardamos la carta correctamente
Route::post('/listings', function (Request $request) {
    
    try {
        // Validamos los datos (Añadido set_id)
        $validated = $request->validate([
            'scryfall_id' => 'required|string',
            'card_name'   => 'required|string',
            'image_url'   => 'required|string',
            'price'       => 'required|numeric|min:0.5',
            'condition'   => 'required|string',
            'is_foil'     => 'boolean',
            'set_id'      => 'required|exists:sets,id', // <--- VALIDAR QUE EL SET EXISTA
        ]);

        // YA NO USAMOS EL SET "GEN" POR DEFECTO. USAMOS EL QUE ELIGIÓ EL USUARIO.

        // Buscamos o creamos la carta
        // IMPORTANTE: Ahora la carta se asocia al set que eligió el usuario
        $card = Card::firstOrCreate(
            ['scryfall_id' => $validated['scryfall_id']], 
            [
                'name' => $validated['card_name'],       
                'image_url' => $validated['image_url'],
                'rarity' => 'unknown', 
                'set_id' => $validated['set_id'] // <--- GUARDAMOS EL SET SELECCIONADO
            ]
        );

        // Si la carta ya existía pero queremos asegurarnos de que tenga el set correcto (opcional):
        // $card->update(['set_id' => $validated['set_id']]);

        // Crear el anuncio
        $listing = new Listing();
        $listing->user_id = Auth::id(); 
        $listing->card_id = $card->id;
        $listing->scryfall_id = $validated['scryfall_id'];
        $listing->price = $validated['price'];
        $listing->condition = $validated['condition'];
        $listing->is_foil = $validated['is_foil'] ?? false;
        $listing->quantity = 1;
        $listing->language = 'en'; // O lo que prefieras

        $listing->save();

        return response()->json(['message' => '¡Carta publicada con éxito!']);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error: ' . $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }

})->middleware(['auth'])->name('listings.store');

Route::middleware(['auth'])->group(function () {
     Route::put('/listings/{id}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{id}', [ListingController::class, 'destroy'])->name('listings.destroy');
});

// Ruta pública para el Catálogo 
Route::get('/api/listings', [ListingController::class, 'index']);

require __DIR__.'/auth.php';