<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http; // <--- IMPORTANTE: Agrega esto arriba del todo

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
Route::get('/trending', function () {
    // order=random hace que cada vez que entres, salgan cartas distintas
    $response = Http::get('https://api.scryfall.com/cards/search', [
        'q' => 'lang:en year>=2020 frame:2015', // Cartas modernas para que se vean bonitas
        'order' => 'random',
        'unique' => 'art'
    ]);

    $data = $response->json();
    
    // TRUCO: Solo devolvemos las 4 primeras para que quede bien en tu HTML
    if (isset($data['data'])) {
        $data['data'] = array_slice($data['data'], 0, 4);
    }

    return $data;
});

// 2. RUTA LORWYN
Route::get('/lorwyn', function () {
    // set:lrw es el código de Magic para "Lorwyn"
    $response = Http::get('https://api.scryfall.com/cards/search', [
        'q' => 'set:lrw', 
        'order' => 'rarity' // Mostramos primero las raras/míticas
    ]);

    $data = $response->json();

    // Solo devolvemos las 4 primeras
    if (isset($data['data'])) {
        $data['data'] = array_slice($data['data'], 0, 4);
    }

    return $data;
});