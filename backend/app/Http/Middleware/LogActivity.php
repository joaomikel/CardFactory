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
        $response = $next($request);

        if (Auth::check()) {
            $user = Auth::user();
            
            $logMessage = sprintf(
                '[Usuario ID: %d | %s] visitó [%s] método [%s]',
                $user->id,
                $user->name,
                $request->path(),
                $request->method()
            );

            if ($request->is('pagar') && $request->method() === 'POST') {
                
                $datosCompra = $request->all();                
                unset($datosCompra['_token']);
                unset($datosCompra['card_number']); 

                $detallesCartas = json_encode($datosCompra, JSON_UNESCAPED_UNICODE);
                
                $logMessage .= " | DETALLES COMPRA: " . $detallesCartas;
            }

            Log::channel('daily')->info($logMessage);
        }

        return $response;
    }
}