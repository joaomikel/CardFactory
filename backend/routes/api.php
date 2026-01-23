<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http; 
use App\Http\Controllers\Api\ListingController;
use App\Http\Controllers\ReviewController;
use App\Models\Card;
use App\Models\Listing;

Route::get('/listings/card/{scryfall_id}', function ($scryfall_id) {
    
    // 1. Buscamos la carta en TU base de datos usando el ID de Scryfall
    $localCard = Card::where('scryfall_id', $scryfall_id)->first();

    // 2. Si no tienes la carta registrada localmente, devuelve array vacío
    if (!$localCard) {
        return response()->json([]);
    }

    // 3. Si la carta existe, buscamos las ventas (Listings) asociadas
    // Usamos 'with' para cargar los datos del Vendedor (User) y del Set (para el nombre de la edición)
    $listings = Listing::where('card_id', $localCard->id)
        ->where('is_sold', false) // Opcional: Solo mostrar si no se ha vendido
        ->with(['user', 'card.set']) // Eager Loading: Trae relaciones para evitar mil consultas
        ->get();

    return response()->json($listings);
});

// Esta ruta busca vendedores usando el ID de Scryfall que viene del catálogo
Route::get('/sellers/{scryfall_id}', function ($scryfall_id) {
    // 1. Buscamos si tenemos esa carta registrada en nuestra BD local
    $localCard = Card::where('scryfall_id', $scryfall_id)->first();

    // 2. Si no existe la carta localmente, nadie la vende
    if (!$localCard) {
        return response()->json([]);
    }

    // 3. Si existe, devolvemos las ventas CON los datos del usuario vendedor
    return $localCard->listings()
        ->with('user') // ¡Importante! Cargar el usuario
        ->where('quantity', '>', 0) // Solo si hay stock (opcional)
        ->get();
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/listings', [ListingController::class, 'store']);

Route::get('/listings/card/{scryfall_id}', [ListingController::class, 'getByCard']);

Route::get('/cartas', function (Request $request) {
    $busqueda = $request->input('q', 'f:standard');
    $respuesta = Http::get('https://api.scryfall.com/cards/search', [
        'q' => $busqueda
    ]);
    return $respuesta->json();
});

Route::get('/lorwyn', function () {
    $response = Http::get('https://api.scryfall.com/cards/search', [
        'q'     => 'set:lrw',   
        'order' => 'random',    
    ]);

    $data = $response->json();
    if (isset($data['data'])) {
        $data['data'] = array_slice($data['data'], 0, 20);
    }
    return $data;
});

Route::get('/trending', function () {
    $response = Http::get('https://api.scryfall.com/cards/search', [
        'q'     => 'lang:en year>=2024',
        'order' => 'random',    
    ]);
    return $response->json();
});

Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/listings/card/{id}', [ListingController::class, 'getByCard']);

// Ruta para crear venta (esta ya la tendrás protegida seguramente)
Route::middleware('auth:sanctum')->post('/listings', [ListingController::class, 'store']);