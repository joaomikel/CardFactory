<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http; // Importante para conectar con Scryfall
use App\Models\User;
use App\Models\Set;
use App\Models\Card;
use App\Models\Listing;

class MagicSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('🌱 Iniciando Seeder Mágico con Scryfall...');

        // 1. Crear Usuarios (Vendedores)
        // Borramos previos para evitar duplicados si corres el seeder varias veces (opcional)
        // User::truncate(); Set::truncate(); Card::truncate(); Listing::truncate();

        $users = [];
        $users[] = User::create(['name' => 'Tienda Magic Madrid', 'email' => 'madrid@test.com', 'password' => bcrypt('123456')]);
        $users[] = User::create(['name' => 'Juan Coleccionista', 'email' => 'juan@test.com', 'password' => bcrypt('123456')]);
        $users[] = User::create(['name' => 'CardMarket Pro', 'email' => 'pro@test.com', 'password' => bcrypt('123456')]);
          
        // Creamos algunos usuarios extra para variedad
        for($i=1; $i<=5; $i++) {
            $users[] = User::factory()->create(); // Asumiendo que tienes UserFactory, si no, borra esta línea
        }

        $this->command->info('✅ Usuarios creados.');

        // 2. Obtener Sets de Scryfall
        $this->command->info('⏳ Descargando ediciones de Scryfall...');
        
        // Obtenemos todas las ediciones
        $response = Http::get('https://api.scryfall.com/sets');
        
        if ($response->failed()) {
            $this->command->error('❌ Error conectando con Scryfall.');
            return;
        }

        $allSets = $response->json()['data'];

        // Filtramos para obtener solo expansiones principales ("expansion" o "core") y recientes
        // para evitar sets raros de tokens o digitales.
        $filteredSets = collect($allSets)
            ->whereIn('set_type', ['expansion', 'core']) 
            ->take(20); // TOMAMOS 20 COLECCIONES

        foreach ($filteredSets as $scryfallSet) {
            
            // Crear la Edición en BD local
            $localSet = Set::firstOrCreate(
                ['code' => $scryfallSet['code']], // Evitar duplicados por código
                ['name' => $scryfallSet['name']]
            );

            $this->command->info("📂 Procesando set: {$localSet->name} ({$localSet->code})");

            // 3. Obtener Cartas de ese Set
            // Buscamos 10 cartas por cada uno de los 20 sets = 200 cartas total
            $cardsResponse = Http::get("https://api.scryfall.com/cards/search?q=e:{$localSet->code}&unique=prints");
            
            if ($cardsResponse->successful()) {
                $cardsData = collect($cardsResponse->json()['data'])->take(10);

                foreach ($cardsData as $cardData) {
                    
                    // Extraer imagen (lógica para cartas normales vs doble cara)
                    $imageUrl = $this->getImageUrl($cardData);

                    // Crear Carta
                    $card = Card::create([
                        'set_id'      => $localSet->id,
                        'name'        => $cardData['name'],
                        'rarity'      => $cardData['rarity'],
                        'image_url'   => $imageUrl,
                        'scryfall_id' => $cardData['id'],
                        // Scryfall a veces no trae oracle_text en la raíz si es doble cara, pero para el ejemplo básico lo dejamos así
                        // 'oracle_text' => $cardData['oracle_text'] ?? '' 
                    ]);

                    // 4. Crear al menos una venta para esta carta
                    $this->createRandomListings($card, $users);
                }
            }

            // Pausa pequeña para no saturar la API (buena práctica)
            usleep(100000); // 0.1 segundos
        }

        $this->command->info('🚀 ¡Base de datos poblada con éxito! 20 Sets y ~200 Cartas con ventas.');
    }

    /**
     * Helper para sacar la imagen, ya que Scryfall varía la estructura
     * si la carta es de doble cara (transform).
     */
    private function getImageUrl($cardData)
    {
        // 1. Intento normal
        if (isset($cardData['image_uris']['large'])) {
            return $cardData['image_uris']['large'];
        }

        // 2. Si es carta doble cara (ej. Kamigawa sagas), la imagen está dentro de 'card_faces'
        if (isset($cardData['card_faces'][0]['image_uris']['large'])) {
            return $cardData['card_faces'][0]['image_uris']['large'];
        }

        // 3. Fallback
        return 'https://via.placeholder.com/400x560?text=No+Image';
    }

    private function createRandomListings($card, $users) 
    {
        // Creamos entre 1 y 4 ventas por carta para que haya variedad
        $numListings = rand(1, 4); 
        
        for($i=0; $i<$numListings; $i++) {
            // Elegir vendedor aleatorio
            $seller = $users[array_rand($users)];

            Listing::create([
                'card_id'     => $card->id,
                'user_id'     => $seller->id,
                // Guardamos el set_name y scryfall_id en el listing por si tu lógica lo requiere para el carrito
                'scryfall_id' => $card->scryfall_id, 
                // Generar precio aleatorio (entre 0.50 y 100.00)
                'price'       => rand(50, 10000) / 100, 
                'condition'   => ['NM', 'EX', 'GD', 'LP', 'PL'][rand(0, 4)],
                'is_foil'     => rand(0, 10) > 8 // 20% de probabilidad de ser Foil
            ]);
        }
    }
}