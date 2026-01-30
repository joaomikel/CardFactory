<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class CatalogController extends Controller
{
    // ... (Tu función index existente se queda igual) ...
    public function index(Request $request)
    {
        $query = Listing::with(['card', 'user'])->where('quantity', '>', 0);

        if ($request->filled('name')) {
            $query->whereHas('card', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }
        if ($request->filled('rarity')) {
            $query->whereHas('card', function($q) use ($request) {
                $q->where('rarity', $request->rarity);
            });
        }
        if ($request->filled('set')) {
             $query->whereHas('card', function($q) use ($request) {
                $q->where('set_id', $request->set); 
            });
        }
        if ($request->filled('color')) {
             $query->whereHas('card', function($q) use ($request) {
                $q->where('color', 'like', '%' . $request->color . '%'); 
            });
        }

        $listings = $query->latest()->get(); 
        return view('catalogo', compact('listings'));
    }

    // --- AÑADE ESTA FUNCIÓN NUEVA AQUI ---
    public function checkStockBatch(Request $request)
    {
        // 1. Validamos que nos envíen un array de IDs
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'string'
        ]);

        $ids = $request->input('ids');

        // 2. Buscamos en la tabla Listings
        // - Que coincida con los scryfall_id
        // - Que tenga stock (quantity > 0)
        // - Agrupamos por scryfall_id y sacamos el precio MÍNIMO
        $stock = Listing::whereIn('scryfall_id', $ids)
            ->where('quantity', '>', 0)
            ->selectRaw('scryfall_id, MIN(price) as min_price')
            ->groupBy('scryfall_id')
            ->get();

        // 3. Formateamos la respuesta para JS: { "uuid-1": 10.50, "uuid-2": 5.00 }
        // 'pluck' crea un array asociativo clave(scryfall_id) => valor(min_price)
        return response()->json($stock->pluck('min_price', 'scryfall_id'));
    }
}