<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up(): void
        {
            Schema::create('listings', function (Blueprint $table) {
                $table->id();
                // Relación con el usuario (vendedor)
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                
                // Datos de la carta y venta
                $table->string('scryfall_id'); // ID único de la carta (API externa)
                $table->decimal('price', 8, 2); // Precio
                $table->integer('quantity')->default(1);
                $table->string('condition')->default('NM'); // NM, LP, MP...
                $table->string('language')->default('ES'); // Idioma
                $table->boolean('is_foil')->default(false);
                
                $table->timestamps();
            });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
