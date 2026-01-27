<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    // 1. Añadimos las rutas de la API y las de Sanctum (login/cookies)
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout', 'register'],

    'allowed_methods' => ['*'],

    // 2. IMPORTANTE: Aquí NO puede haber un '*' si usas credenciales.
    // Pon la IP de tu Ubuntu (desde donde sirves la web) y localhost por si acaso.
    'allowed_origins' => [
        'http://10.10.18.108',
        'http://localhost',
        'http://127.0.0.1',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // 3. CRUCIAL: Esto tiene que ser TRUE para que acepte las cookies
    'supports_credentials' => true,

];