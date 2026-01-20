<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ListingFactory extends Factory
{
    public function definition(): array
    {
        // Estos son IDs reales de Scryfall de cartas populares
        // Así aseguramos que al buscar estas cartas, TENGAN vendedores.
        $idsReales = [
            '4a30bcfa-6f2b-44e0-b7f2-99fc4696aec8', // Sheoldred, the Apocalypse
            'cf9df1cc-9de3-42a6-9c28-f2d5ad75657b', // The One Ring
            'bd8fa327-dd41-4737-8f19-2cf5eb1f7cdd', // Black Lotus
            '46407d93-df48-4161-8bf6-313d129d4c8f', // Sol Ring
            'a88d52a2-3837-4592-8a9d-16bd428387fd', // Llanowar Elves (Foundations)
        ];

        return [
            // Esto crea un usuario automáticamente por cada venta si no se especifica uno
            'user_id' => User::factory(), 
            
            // Elige un ID de carta real al azar
            'scryfall_id' => $this->faker->randomElement($idsReales),
            
            // Genera precios, condiciones e idiomas aleatorios
            'price' => $this->faker->randomFloat(2, 10, 500), // Precio entre 10.00 y 500.00
            'quantity' => $this->faker->numberBetween(1, 4),
            'condition' => $this->faker->randomElement(['NM', 'LP', 'MP', 'HP']),
            'language' => $this->faker->randomElement(['ES', 'EN', 'JP']),
            'is_foil' => $this->faker->boolean(20), // 20% de probabilidad de ser Foil
        ];
    }
}