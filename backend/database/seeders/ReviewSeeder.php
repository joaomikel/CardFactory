<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $reviews = [
            ['name' => "Adrian DLC", 'text' => "Me encanta ver los precios actualizados al momento.", 'img' => "https://i.pravatar.cc/150?u=adrian"],
            ['name' => "Marina G.", 'text' => "El diseño de Lorwyn me parece increíble, web top.", 'img' => "https://i.pravatar.cc/150?u=marina"],
            ['name' => "Carlos R.", 'text' => "Muy intuitivo desde el móvil, compro siempre aquí.", 'img' => "https://i.pravatar.cc/150?u=carlos"],
            ['name' => "Sofia L.", 'text' => "El buscador funciona rapidísimo. ¡Genial!", 'img' => "https://i.pravatar.cc/150?u=sofia"],
            ['name' => "Miguel Angel", 'text' => "Vendí mis cartas y recibí el dinero en 24h.", 'img' => "https://i.pravatar.cc/150?u=miguel"],
            ['name' => "Lucía P.", 'text' => "La mejor comunidad de Magic en España.", 'img' => "https://i.pravatar.cc/150?u=lucia"],
            ['name' => "David B.", 'text' => "Encontré la Sheoldred Foil que buscaba.", 'img' => "https://i.pravatar.cc/150?u=david"],
            ['name' => "Elena T.", 'text' => "Soporte técnico muy amable y rápido.", 'img' => "https://i.pravatar.cc/150?u=elena"],
            ['name' => "Jorge M.", 'text' => "Los envíos llegan súper protegidos.", 'img' => "https://i.pravatar.cc/150?u=jorge"],
            ['name' => "Raquel S.", 'text' => "Precios muy competitivos comparado con MKM.", 'img' => "https://i.pravatar.cc/150?u=raquel"],
            ['name' => "Pablo K.", 'text' => "La interfaz oscura es perfecta para la noche.", 'img' => "https://i.pravatar.cc/150?u=pablo"],
            ['name' => "Ana V.", 'text' => "Me gusta poder filtrar por rareza tan fácil.", 'img' => "https://i.pravatar.cc/150?u=ana"],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}