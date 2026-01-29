<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabla de EDICIONES (Sets)
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('icon_svg')->nullable();
            $table->timestamps();
        });

        // 2. Tabla de CARTAS (Cards)
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scryfall_id')->nullable();
            $table->string('image_url');
            $table->string('rarity');
            $table->foreignId('set_id')->nullable()->constrained('sets')->onDelete('cascade');            $table->timestamps();
        });

        // 3. Tabla de VENTAS/LISTINGS
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            
            // Relación con el Usuario (Vendedor)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // --- ESTA ES LA LÍNEA QUE FALTABA (Relación con la Carta) ---
            $table->foreignId('card_id')->constrained()->onDelete('cascade');
            // ------------------------------------------------------------

            // ID de Scryfall (Texto)
            $table->string('scryfall_id'); 

            $table->decimal('price', 8, 2);
            $table->integer('quantity')->default(1);
            $table->string('condition')->default('NM');
            $table->string('language')->default('ES');
            $table->boolean('is_foil')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listings');
        Schema::dropIfExists('cards');
        Schema::dropIfExists('sets');
    }
};