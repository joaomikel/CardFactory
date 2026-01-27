<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http; 
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\ReviewController;
use App\Models\Card;
use App\Models\Listing;

// -------------------------------------------------------------------------
// RUTAS PÚBLICAS (Cualquiera puede verlas sin loguearse)
// -------------------------------------------------------------------------
Route::get('/tendencias', function () {
    // Busca las 4 últimas cartas con stock
    // Devuelve JSON puro para que el HTML lo lea
    return Listing::with('card')
        ->where('quantity', '>', 0)
        ->latest()
        ->take(4)
        ->get();
});
// 1. Ver cartas por ID de Scryfall (Esta estaba repetida, dejamos una sola)
Route::get('/listings/card/{scryfall_id}', [ListingController::class, 'getByCard']);

// 2. Buscar vendedores de una carta
Route::get('/sellers/{scryfall_id}', function ($scryfall_id) {
    $localCard = Card::where('scryfall_id', $scryfall_id)->first();
    if (!$localCard) {
        return response()->json([]);
    }
    return $localCard->listings()->with('user')->where('quantity', '>', 0)->get();
});

// 3. Buscador de cartas (Scryfall)
Route::get('/cartas', function (Request $request) {
    $busqueda = $request->input('q', 'f:standard');
    return Http::get('https://api.scryfall.com/cards/search', ['q' => $busqueda])->json();
});

// 4. Edición Lorwyn
Route::get('/lorwyn', function () {
    $data = Http::get('https://api.scryfall.com/cards/search', ['q' => 'set:lrw', 'order' => 'random'])->json();
    if (isset($data['data'])) {
        $data['data'] = array_slice($data['data'], 0, 20);
    }
    return $data;
});

// 5. Trending
Route::get('/trending', function () {
    return Http::get('https://api.scryfall.com/cards/search', ['q' => 'lang:en year>=2024', 'order' => 'random'])->json();
});

// 6. Reviews
Route::get('/reviews', [ReviewController::class, 'index']);


// -------------------------------------------------------------------------
// RUTAS PRIVADAS (Necesitas estar logueado)
// -------------------------------------------------------------------------

Route::middleware('auth:sanctum')->group(function () {
    
    // Obtener el usuario actual
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // CREAR UNA VENTA (Aquí es donde te daba el 401)
    Route::post('/listings', [ListingController::class, 'store']);
});