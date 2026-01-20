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
            $table->string('name'); // Ej: Kamigawa: Neon Dynasty
            $table->string('code')->unique(); // Ej: neo
            $table->string('icon_svg')->nullable(); // Para el icono de Keyrune
            $table->timestamps();
        });

        // 2. Tabla de CARTAS (Cards)
        // Relación 1:N -> Una edición tiene muchas cartas
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('scryfall_id')->nullable(); // Útil para imágenes
            $table->string('image_url'); // URL de la imagen
            $table->string('rarity'); // common, rare, etc.
            
            // FK hacia la tabla Sets
            $table->foreignId('set_id')->constrained('sets')->onDelete('cascade');
            
            $table->timestamps();
        });

        // 3. Tabla de VENTAS/LISTINGS (La relación N:M entre Usuarios y Cartas)
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            
            // Relación N:M (Muchos usuarios venden muchas cartas)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('card_id')->constrained('cards')->onDelete('cascade');
            
            $table->decimal('price', 8, 2);
            $table->string('condition')->default('NM'); // NM, LP, MP...
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