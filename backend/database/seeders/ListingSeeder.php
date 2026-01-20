<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\User;

class ListingSeeder extends Seeder
{
    public function run()
    {
        // 1. IDs de Scryfall de cartas REALES y populares
        $cartasReales = [
            'cf9df1cc-9de3-42a6-9c28-f2d5ad75657b', // The One Ring
            'd67be074-cdd4-41d9-ac89-0a0456c4e4b2', // Sheoldred, the Apocalypse
            '46e31b77-3832-496e-9130-4e795a9eadba', // Orcish Bowmasters
            'a2c5a890-449a-4166-a36c-94101e4e69b9', // Beseech the Mirror
            'b0fa8481-9657-4152-8d74-c376f9c97b0a', // Sol Ring
        ];

        // 2. Si no hay usuarios, creamos 10 falsos
        if (User::count() == 0) {
            User::factory(10)->create();
        }
        
        // Cogemos todos los usuarios para asignarles ventas
        $users = User::all();

        // 3. Crear ventas para cada carta
        foreach ($cartasReales as $scryfallId) {
            
            // Creamos entre 2 y 5 vendedores para CADA carta
            $numVendedores = rand(2, 5);

            for ($i = 0; $i < $numVendedores; $i++) {
                Listing::create([
                    'user_id'     => $users->random()->id, // Relación con el Proveedor
                    'scryfall_id' => $scryfallId,
                    'price'       => rand(1000, 8000) / 100, // Precio aleatorio
                    'condition'   => collect(['NM', 'LP', 'MP'])->random(),
                    'language'    => collect(['EN', 'ES', 'JP'])->random(),
                    'is_foil'     => (bool)rand(0, 1),
                    'quantity'    => 1
                ]);
            }
        }
    }
}