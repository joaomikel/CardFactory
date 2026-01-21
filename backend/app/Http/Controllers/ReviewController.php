<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; // <--- IMPRESCINDIBLE importar esto

class ReviewController extends Controller
{
    public function index()
    {
        // Coge 3 reseñas aleatorias de la base de datos
        $reviews = Review::inRandomOrder()->take(3)->get();

        return response()->json($reviews);
    }
}