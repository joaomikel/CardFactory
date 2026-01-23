<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller; 
use App\Models\Card;
use App\Models\Listing;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ListingController extends Controller
{
    // --- FUNCIÓN PARA GUARDAR (YA LA TENÍAS) ---
    public function store(Request $request)
    {
        // 1. Validamos los datos básicos
        $request->validate([
            'card_id' => 'required|string',
            'price' => 'required|numeric',
            'condition' => 'required|string',
        ]);

        $scryfallId = $request->card_id;

        // 2. Comprobamos si la carta YA existe en local
        $card = Card::where('scryfall_id', $scryfallId)->first();

        // 3. SI NO EXISTE: La creamos
        if (!$card) {
            $response = Http::withoutVerifying()->get("https://api.scryfall.com/cards/$scryfallId");            
            
            if ($response->failed()) {
                return response()->json(['message' => 'Error al obtener datos de Scryfall'], 500);
            }

            $data = $response->json();

            // A) GESTIÓN DEL SET
            $set = Set::firstOrCreate(
                ['code' => $data['set']], 
                [
                    'name' => $data['set_name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // B) GESTIÓN DE LA CARTA
            $imageUrl = $data['image_uris']['normal'] 
                ?? $data['card_faces'][0]['image_uris']['normal'] 
                ?? null;

            $card = Card::create([
                'name' => $data['name'],
                'scryfall_id' => $data['id'],
                'image_url' => $imageUrl,
                'rarity' => $data['rarity'],
                'set_id' => $set->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. CREAR LA VENTA
        $listing = $request->user()->listings()->create([
            'card_id' => $card->id,
            'price' => $request->price,
            'quantity' => 1,
            'condition' => $request->condition,
            'is_foil' => $request->is_foil ?? false,
            'language' => 'ES',
            'scryfall_id' => $scryfallId 
        ]);

        return response()->json([
            'message' => 'Producto publicado con éxito',
            'listing' => $listing,
            'card' => $card
        ], 201);
    }

    // --- ¡ESTA ES LA FUNCIÓN QUE TE FALTABA! ---
    public function getByCard($scryfallId)
    {
        // Buscamos las ventas que coincidan con el ID de Scryfall
        $listings = Listing::where('scryfall_id', $scryfallId)
            ->with(['user', 'card.set']) // <--- AQUÍ ESTÁ LA SOLUCIÓN: Carga el usuario y la carta
            ->get();

        return response()->json($listings);
    }
}