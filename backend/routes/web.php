<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Models\Listing;
use App\Models\Card; 

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

// 1. Mostrar el formulario
Route::get('/vender', function () {
    return view('vender');
})->middleware(['auth'])->name('vender');

// 2. Procesar la venta
Route::post('/listings', function (Request $request) {
    
    // Validamos los datos que vienen del formulario
    $validated = $request->validate([
        'scryfall_id' => 'required|string',
        'card_name'   => 'required|string',
        'image_url'   => 'required|string',
        'price'       => 'required|numeric|min:0.5',
        'condition'   => 'required|string',
        'is_foil'     => 'boolean',
    ]);

    // A. BUSCAR O CREAR LA CARTA
    // Adaptado a tu Card.php que pide 'rarity' y 'set_id'
    $card = Card::firstOrCreate(
        ['scryfall_id' => $validated['scryfall_id']], 
        [
            'name' => $validated['card_name'],       
            'image_url' => $validated['image_url'],
            
            // NUEVO: Valores por defecto para que no falle tu modelo Card
            'rarity' => 'unknown', // Ponemos un valor genérico si no lo sabemos
            'set_id' => null       // IMPORTANTE: Asegúrate de que tu columna 'set_id' en la BD acepte NULL
        ]
    );

    // B. CREAR EL ANUNCIO (LISTING)
    $listing = new Listing();
    $listing->user_id = Auth::id(); 
    $listing->card_id = $card->id;
    
    // NUEVO: Tu modelo Listing pide scryfall_id también
    $listing->scryfall_id = $validated['scryfall_id'];
    
    $listing->price = $validated['price'];
    $listing->condition = $validated['condition'];
    $listing->is_foil = $validated['is_foil'] ?? false;

    // NUEVO: Tu modelo Listing pide quantity y language
    $listing->quantity = 1;       // Por defecto vendemos 1 unidad
    $listing->language = 'en';    // Por defecto inglés (o puedes poner 'es')

    $listing->save();

    return response()->json(['message' => '¡Carta publicada con éxito!']);

})->middleware(['auth']); 

require __DIR__.'/auth.php';