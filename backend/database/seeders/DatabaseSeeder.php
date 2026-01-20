<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Listing; // <--- ¡ESTA ES LA LÍNEA QUE FALTA!

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuario Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Crear 20 Vendedores con 3 cartas cada uno
        User::factory(20)
            ->has(Listing::factory()->count(3)) 
            ->create();

        echo "¡Base de datos poblada con 21 usuarios y +60 cartas en venta!";
    }
}