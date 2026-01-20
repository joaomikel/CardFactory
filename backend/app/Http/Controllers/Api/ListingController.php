<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Obtener vendedores por ID de carta
    public function getByCard($scryfall_id)
    {
        // Buscamos en la tabla listings, incluyendo datos del usuario (vendedor)
        $listings = Listing::where('scryfall_id', $scryfall_id)
                    ->with('user:id,name') // Solo traemos id y nombre del vendedor
                    ->orderBy('price', 'asc') // Ordenar por precio barato
                    ->get();

        return response()->json($listings);
    }
    public function getByScryfallId($scryfall_id)
    {
        // 1. Buscamos en la columna 'scryfall_id'
        // 2. Usamos 'with('user')' para traer el nombre del vendedor
        // 3. Usamos 'get()' porque pueden haber MUCHOS vendedores para una misma carta
        $listings = Listing::where('scryfall_id', $scryfall_id)
                            ->with('user') // Carga la relación del usuario
                            ->get();

        if ($listings->isEmpty()) {
            return response()->json(['message' => 'No hay vendedores para esta carta'], 404);
        }

        return response()->json($listings);
    }
}