<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Set;
use App\Models\Card;
use App\Models\Listing;

class MagicSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear Usuarios (Vendedores)
        $user1 = User::create(['name' => 'Tienda Magic Madrid', 'email' => 'madrid@test.com', 'password' => bcrypt('123456')]);
        $user2 = User::create(['name' => 'Juan Coleccionista', 'email' => 'juan@test.com', 'password' => bcrypt('123456')]);
        $user3 = User::create(['name' => 'CardMarket Pro', 'email' => 'pro@test.com', 'password' => bcrypt('123456')]);
        
        $sellers = [$user1, $user2, $user3];

        // 2. Crear EDICIONES (Sets)
        $setNeo = Set::create(['name' => 'Kamigawa: Neon Dynasty', 'code' => 'neo']);
        $setDmu = Set::create(['name' => 'Dominaria United', 'code' => 'dmu']);
        $setOne = Set::create(['name' => 'Phyrexia: All Will Be One', 'code' => 'one']);

        // 3. Crear CARTAS (Con IDs REALES de Scryfall)
        
        // --- CARTAS KAMIGAWA (NEO) ---
        $cardsNeo = [
            // The Wandering Emperor
            ['id' => 'fab2f8dd-c01d-4527-8c52-0f18320078ac', 'name' => 'The Wandering Emperor', 'rarity' => 'mythic', 'img' => 'https://cards.scryfall.io/large/front/f/a/fab2f8dd-c01d-4527-8c52-0f18320078ac.jpg'],
            // Boseiju, Who Endures
            ['id' => '2135ac5a-187b-4dc9-8f82-34e8d1603416', 'name' => 'Boseiju, Who Endures', 'rarity' => 'rare', 'img' => 'https://cards.scryfall.io/large/front/2/1/2135ac5a-187b-4dc9-8f82-34e8d1603416.jpg'],
        ];

        foreach($cardsNeo as $c) {
            $card = Card::create([
                'set_id' => $setNeo->id,
                'name' => $c['name'],
                'rarity' => $c['rarity'],
                'image_url' => $c['img'],
                'scryfall_id' => $c['id'] // <--- IMPORTANTE: ID Real
            ]);
            $this->createRandomListings($card, $sellers);
        }

        // --- CARTAS DOMINARIA (DMU) ---
        $cardsDmu = [
            // Sheoldred, the Apocalypse
            ['id' => 'd67be074-cdd4-41d9-ac89-0a0456c4e4b2', 'name' => 'Sheoldred, the Apocalypse', 'rarity' => 'mythic', 'img' => 'https://cards.scryfall.io/large/front/d/6/d67be074-cdd4-41d9-ac89-0a0456c4e4b2.jpg'],
            // Liliana of the Veil
            ['id' => 'd12c8c97-6491-452c-811d-943441a7ef9f', 'name' => 'Liliana of the Veil', 'rarity' => 'mythic', 'img' => 'https://cards.scryfall.io/large/front/d/1/d12c8c97-6491-452c-811d-943441a7ef9f.jpg'],
        ];

        foreach($cardsDmu as $c) {
            $card = Card::create([
                'set_id' => $setDmu->id,
                'name' => $c['name'],
                'rarity' => $c['rarity'],
                'image_url' => $c['img'],
                'scryfall_id' => $c['id']
            ]);
            $this->createRandomListings($card, $sellers);
        }

        // --- CARTAS PHYREXIA (ONE) ---
        $cardsOne = [
            // Elesh Norn, Mother of Machines
            ['id' => '44dcab01-1d13-4dfc-ae2f-fbaa3dd35087', 'name' => 'Elesh Norn, Mother of Machines', 'rarity' => 'mythic', 'img' => 'https://cards.scryfall.io/large/front/4/4/44dcab01-1d13-4dfc-ae2f-fbaa3dd35087.jpg'],
        ];

        foreach($cardsOne as $c) {
            $card = Card::create([
                'set_id' => $setOne->id,
                'name' => $c['name'],
                'rarity' => $c['rarity'],
                'image_url' => $c['img'],
                'scryfall_id' => $c['id']
            ]);
            $this->createRandomListings($card, $sellers);
        }
    }

    private function createRandomListings($card, $sellers) {
        $numSellers = rand(1, 3); 
        
        for($i=0; $i<$numSellers; $i++) {
            Listing::create([
                'card_id' => $card->id,
                'user_id' => $sellers[rand(0, 2)]->id,
                'scryfall_id' => $card->scryfall_id, 
                'price' => rand(500, 8000) / 100, 
                'condition' => ['NM', 'EX', 'GD'][rand(0, 2)],
                'is_foil' => rand(0, 1) == 1
            ]);
        }
    }
}