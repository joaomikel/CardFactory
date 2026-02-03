<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Listing;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    // 1. LISTAR (Para el catálogo)
    public function index(Request $request)
    {
        $listings = Listing::with(['card', 'user'])->latest()->get();
        return response()->json($listings);
    }

    // 2. GUARDAR (Para publicar ventas)
    public function store(Request $request)
    {
        try {
            // Validamos los datos (Añadido set_id)
            $validated = $request->validate([
                'scryfall_id' => 'required|string',
                'card_name'   => 'required|string',
                'image_url'   => 'required|string',
                'price'       => 'required|numeric|min:0.5',
                'condition'   => 'required|string',
                'is_foil'     => 'boolean',
                'set_id'      => 'required|exists:sets,id', 
            ]);

            // Buscamos o creamos la carta asociada al set
            $card = Card::firstOrCreate(
                ['scryfall_id' => $validated['scryfall_id']], 
                [
                    'name' => $validated['card_name'],       
                    'image_url' => $validated['image_url'],
                    'rarity' => 'unknown', 
                    'set_id' => $validated['set_id'] 
                ]
            );

            // Crear el anuncio
            $listing = new Listing();
            $listing->user_id = Auth::id(); 
            $listing->card_id = $card->id;
            $listing->scryfall_id = $validated['scryfall_id'];
            $listing->price = $validated['price'];
            $listing->condition = $validated['condition'];
            $listing->is_foil = $validated['is_foil'] ?? false;
            $listing->quantity = 1;
            $listing->language = 'en'; 

            $listing->save();

            return response()->json(['message' => '¡Carta publicada con éxito!']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    // 3. ACTUALIZAR (Para el botón EDITAR del Dashboard)
    public function update(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        // Validar que el usuario es el dueño
        if ($listing->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No tienes permiso.');
        }

        $request->validate([
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string',
            'set_id' => 'required|exists:sets,id', // Validamos el set
        ]);

        // Actualizamos precio y condición del LISTING
        $listing->update([
            'price' => $request->price,
            'condition' => $request->condition,
        ]);

        // Actualizamos el set de la CARTA (CARD)
        // OJO: Esto cambiará el set para esta carta. 
        $listing->card->update([
            'set_id' => $request->set_id
        ]);

        return redirect()->back()->with('status', 'Producto actualizado correctamente.');
    }
    // 4. ELIMINAR (Para el botón BORRAR del Dashboard)
    public function destroy($id)
    {
        // 1. Buscamos la carta asegurando que sea del usuario conectado
        $listing = Listing::where('id', $id)->where('user_id', Auth::id())->first();

        // 2. Si algo falla (no existe o no es tuya)
        if (!$listing) {
            return back()->with('error', 'No se pudo borrar la carta.');
        }

        // 3. La borramos de verdad
        $listing->delete();

        // 4. ¡ESTO ES LO QUE RECARGA LA PÁGINA!
        return back()->with('status', 'Carta eliminada correctamente.');
    }

    // 5. DETALLE
    public function getByCard($scryfallId)
    {
        $listings = Listing::where('scryfall_id', $scryfallId)->with('user')->get();
        return response()->json($listings);
    }
}