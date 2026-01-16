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

// ... Mantén las otras rutas (trending, lorwyn) como las tenías o haz lo mismo con ellas

Route::get('/trending', function () {
    return response()->json([
        'data' => [
            [
                'name' => 'Sheoldred, the Apocalypse',
                'prices' => ['eur' => '85.50'],
                'image_uris' => ['normal' => 'https://cards.scryfall.io/normal/front/d/6/d67be074-cdd4-41d9-ac89-0a0456c4e4b2.jpg']
            ],
            [
                'name' => 'The One Ring',
                'prices' => ['eur' => '110.00'],
                'image_uris' => ['normal' => 'https://cards.scryfall.io/normal/front/d/5/d5806e68-1054-458e-866d-1f2470f682b2.jpg']
            ],
            [
                'name' => 'Orcish Bowmasters',
                'prices' => ['eur' => '45.00'],
                'image_uris' => ['normal' => 'https://cards.scryfall.io/normal/front/7/c/7c024bae-5631-4e20-ac69-df392ac9e109.jpg']
            ],
            [
                'name' => 'Black Lotus (Proxy)',
                'prices' => ['usd' => '99999'],
                'image_uris' => ['normal' => 'https://cards.scryfall.io/normal/front/b/d/bd8fa327-dd41-4737-8f19-2cf5eb1f7cdd.jpg']
            ]
        ]
    ]);
});

// RUTA PARA LORWYN (HOME)
Route::get('/lorwyn', function () {
    return response()->json([
        'data' => [
            [
                'name' => 'Cryptic Command',
                'prices' => ['eur' => '12.00'],
                'image_uris' => ['normal' => 'https://cards.scryfall.io/normal/front/3/0/30f6fca9-003b-4f6b-9d6e-1e88adda4155.jpg']
            ],
            [
                'name' => 'Thoughtseize',
                'prices' => ['eur' => '18.50'],
                'image_uris' => ['normal' => 'https://cards.scryfall.io/normal/front/b/2/b281a308-ab6b-47b6-bec7-632c9aaecede.jpg']
            ],
            [
                'name' => 'Mulldrifter',
                'prices' => ['eur' => '0.50'],
                'image_uris' => ['normal' => 'https://cards.scryfall.io/normal/front/d/9/d9fb2f2b-ed82-4461-9013-490e8bca89f2.jpg']
            ],
            [
                'name' => 'Liliana Vess',
                'prices' => ['eur' => '8.00'],
                'image_uris' => ['normal' => 'https://cards.scryfall.io/normal/front/9/6/96bb667b-7240-4072-beb7-9a803c9eabe3.jpg']
            ]
        ]
    ]);
});