<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // Relación con el usuario: si se borra el usuario, se borra el perfil (cascade)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Campos movidos del usuario
            $table->string('surname')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};