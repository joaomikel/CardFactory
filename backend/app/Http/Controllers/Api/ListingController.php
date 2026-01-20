<?php

namespace App\Http\Controllers\Api;

// --- ESTA ES LA LÍNEA QUE TE FALTA ---
use App\Http\Controllers\Controller;
// --------------------------------------

use App\Models\Listing;
use App\Models\Card;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // Obtener todas las ventas
    public function index()
    {
        return Listing::with(['card.set', 'user'])->get();
    }

    // Obtener las ventas de una carta específica
    public function getByCard($scryfallId)
    {
        // 1. Buscamos la carta en nuestra base de datos local
        $card = Card::where('scryfall_id', $scryfallId)->first();

        // 2. Si la carta no existe en nuestra DB, devolvemos lista vacía
        // (Porque si no tenemos la carta, imposible que tengamos ventas de ella)
        if (!$card) {
            return response()->json([]);
        }

        // 3. Si la carta existe, buscamos las ventas asociadas
        $listings = Listing::where('card_id', $card->id)
            ->with('user') // Traemos datos del vendedor
            ->get();

        // 4. Formateamos la respuesta para que el Frontend la entienda fácil
        $data = $listings->map(function ($listing) {
            return [
                'id' => $listing->id,
                'price' => $listing->price,
                'condition' => $listing->condition,
                'is_foil' => $listing->is_foil,
                'seller_name' => $listing->user->name, // Nombre del vendedor
                'seller_rating' => 4.8 // (Simulado por ahora)
            ];
        });

        return response()->json($data);
    }
}