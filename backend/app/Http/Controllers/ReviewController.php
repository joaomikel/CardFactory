<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Tu función index ya existente...
    public function index()
    {
        return Review::latest()->take(3)->get();
    }

    // --- AÑADE ESTA FUNCIÓN NUEVA ---
    public function store(Request $request)
    {
        // 1. Validamos que envíen nombre y texto
        $request->validate([
            'name' => 'required|string|max:50',
            'text' => 'required|string|max:255',
        ]);

        // 2. Creamos la reseña en la DB
        $review = Review::create([
            'name' => $request->name,
            'text' => $request->text,
            // Truco: Generamos un avatar automático con su nombre para guardar en la DB
            'img'  => 'https://ui-avatars.com/api/?name=' . urlencode($request->name) . '&background=random' 
        ]);

        return response()->json(['message' => 'Reseña creada', 'data' => $review], 201);
    }
}