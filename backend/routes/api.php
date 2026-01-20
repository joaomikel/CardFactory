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

// --- RUTA QUE FALTABA O ESTABA MAL ---
// He añadido "/card" para que coincida con tu HTML
Route::get('/listings/card/{scryfall_id}', [ListingController::class, 'getByCard']);


// --- TUS OTRAS RUTAS (ESTÁN BIEN) ---

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