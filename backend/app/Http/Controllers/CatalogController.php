<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class CatalogController extends Controller
{
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

    public function checkStockBatch(Request $request)
    {
        // 1. Validamos que nos envíen un array de IDs
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'string'
        ]);

        $ids = $request->input('ids');

        // 2. Buscamos en la tabla Listings
        // Que coincida con los scryfall_id
        // Que tenga stock (quantity > 0)
        // Agrupamos por scryfall_id y sacamos el precio MÍNIMO
        $stock = Listing::whereIn('scryfall_id', $ids)
            ->where('quantity', '>', 0)
            ->selectRaw('scryfall_id, MIN(price) as min_price')
            ->groupBy('scryfall_id')
            ->get();

        // 3. Formateamos la respuesta para JS: { "uuid-1": 10.50, "uuid-2": 5.00 }
        // 'pluck' crea un array asociativo clave(scryfall_id) => valor(min_price)
        return response()->json($stock->pluck('min_price', 'scryfall_id'));
    }
    public function showCard(Request $request)
    {
        // Obtenemos el ID de la URL (?id=...)
        $cardId = $request->query('id');

        // Buscamos las ventas locales para esa carta
        // Usamos 'with' para cargar el usuario y el set y que sea eficiente
        $listings = \App\Models\Listing::where('scryfall_id', $cardId)
                        ->with(['user', 'card.set'])
                        ->get();

        // Devolvemos la vista pasando las ofertas ($listings)
        return view('carta', compact('listings', 'cardId'));
    }
}