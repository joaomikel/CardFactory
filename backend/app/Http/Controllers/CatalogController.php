<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // 1. Consulta base (Ventas con stock y datos de carta/usuario)
        $query = Listing::with(['card', 'user'])->where('quantity', '>', 0);

        // 2. Filtros (Igual que antes)
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

        // 3. OBTENER DATOS Y DEVOLVER VISTA
        // Usamos 'paginate(20)' para que salgan 20 por página (opcional) o 'get()' para todas.
        $listings = $query->latest()->get(); 

        // ESTA ES LA CLAVE: Devolvemos la vista 'catalogo' y le pasamos la variable $listings
        return view('catalogo', compact('listings'));
    }
}