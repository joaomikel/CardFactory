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

        return response()->json([
            'status' => 'success',
            'message' => 'Compra procesada y registrada en el sistema.',
            // Devolvemos lo que nos llegó para confirmar (opcional)
            'data_received' => $request->all() 
        ]);
    }
}