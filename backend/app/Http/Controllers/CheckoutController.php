<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'amount' => 'required|numeric',
        ]);

        $minimo = 10.00;
        
        $subtotalCalculado = collect($request->items)->sum('price');

        if ($subtotalCalculado < $minimo) {
            return response()->json([
                'status' => 'error',
                'message' => 'El pedido mínimo es de ' . $minimo . ' euros.'
            ], 400); 
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Compra procesada correctamente.'
        ]);
    }
}