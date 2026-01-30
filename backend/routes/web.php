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
    $listings = Auth::user()->listings()->with('card')->latest()->get();
    return view('dashboard', ['listings' => $listings]);
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

Route::get('/carta', function () {
    return view('carta');
});



// --- ZONA DE VENTAS ---

Route::get('/vender', function () {
    return view('vender');
})->middleware(['auth'])->name('vender');

Route::post('/listings', function (Request $request) {
    
    // 1. Envolvemos todo en try-catch para ver el error si falla
    try {
        $validated = $request->validate([
            'scryfall_id' => 'required|string',
            'card_name'   => 'required|string',
            'image_url'   => 'required|string',
            'price'       => 'required|numeric|min:0.5',
            'condition'   => 'required|string',
            'is_foil'     => 'boolean',
        ]);

        $defaultSet = Set::firstOrCreate(
            ['code' => 'GEN'], // Buscamos por código 'GEN'
            [
                'name' => 'General / Desconocido',
                'code' => 'GEN',
                'icon_svg' => null 
            ]
        );

        // 2. BUSCAR O CREAR LA CARTA
        $card = Card::firstOrCreate(
            ['scryfall_id' => $validated['scryfall_id']], 
            [
                'name' => $validated['card_name'],       
                'image_url' => $validated['image_url'],
                'rarity' => 'unknown', 
                'set_id' => $defaultSet->id 
            ]
        );

        // 3. CREAR EL ANUNCIO
        $listing = new Listing();
        $listing->user_id = Auth::id(); 
        $listing->card_id = $card->id;
        $listing->scryfall_id = $validated['scryfall_id'];
        $listing->price = $validated['price'];
        $listing->condition = $validated['condition'];
        $listing->is_foil = $validated['is_foil'] ?? false;
        $listing->quantity = 1;
        $listing->language = 'en';

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