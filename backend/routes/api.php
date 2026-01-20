<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http; 
use App\Http\Controllers\Api\ListingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// RUTA REAL CONECTADA A SCRYFALL
Route::get('/cartas', function (Request $request) {
    // 1. Recogemos lo que busca el usuario (ej: "f:standard")
    // Si no busca nada, por defecto buscamos "f:standard"
    $busqueda = $request->input('q', 'f:standard');

    // 2. Laravel llama a Scryfall por ti (Backend a Backend)
    $respuesta = Http::get('https://api.scryfall.com/cards/search', [
        'q' => $busqueda
    ]);

    // 3. Devolvemos al Frontend exactamente lo que dijo Scryfall
    return $respuesta->json();
});

// 1. RUTA TRENDING (ALEATORIA)
Route::get('/lorwyn', function () {
    $response = Http::get('https://api.scryfall.com/cards/search', [
        'q'     => 'set:lrw',   // Filtra por Lorwyn
        'order' => 'random',    // <--- ESTO ES LO QUE FALTA (Baraja todo el set)
    ]);

    $data = $response->json();

    // Opcional: limitar a 10 resultados para no saturar el JSON
    if (isset($data['data'])) {
        $data['data'] = array_slice($data['data'], 0, 20);
    }

    return $data;
});

Route::get('/trending', function () {
    $response = Http::get('https://api.scryfall.com/cards/search', [
        'q'     => 'lang:en year>=2024',
        'order' => 'random',    // <--- TAMBIÉN AQUÍ para que no salgan solo de la "A"
    ]);

    return $response->json();
});

Route::get('/listings/{scryfall_id}', [ListingController::class, 'getByCard']);