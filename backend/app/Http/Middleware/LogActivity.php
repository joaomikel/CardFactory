<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        // Ejecutamos la petición primero
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();
            
            // Mensaje base
            $logMessage = sprintf(
                '[Usuario ID: %d | %s] visitó [%s] método [%s]',
                $user->id,
                $user->name,
                $request->path(),
                $request->method()
            );

            // --- LÓGICA ESPECIAL PARA COMPRAS ---
            // Si la ruta es 'pagar' y es un POST (envío de datos)
            if ($request->is('pagar') && $request->method() === 'POST') {
                
                // Intentamos capturar los datos del carrito que vienen del Frontend
                // Asumimos que envías un array llamado 'items' o 'cart'
                $datosCompra = $request->all(); // Captura todo lo que envía el formulario/fetch
                
                // Filtramos datos sensibles (como token o tarjeta si hubiera)
                unset($datosCompra['_token']);
                unset($datosCompra['card_number']); 

                // Convertimos el array de cartas a texto para el log
                $detallesCartas = json_encode($datosCompra, JSON_UNESCAPED_UNICODE);
                
                $logMessage .= " | DETALLES COMPRA: " . $detallesCartas;
            }

            Log::channel('daily')->info($logMessage);
        }

        return $response;
    }
}