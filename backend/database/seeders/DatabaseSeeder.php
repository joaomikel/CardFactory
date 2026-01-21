<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Al llamar solo a este, se ejecuta toda tu lógica en orden
        $this->call([
            MagicSeeder::class,
        ]);
    }
}