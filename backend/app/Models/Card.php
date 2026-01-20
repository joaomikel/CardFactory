<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    // Una Carta pertenece a un Set (Relación inversa del 1:N)
    public function set() {
        return $this->belongsTo(Set::class);
    }

    // Una Carta tiene muchas Ventas (Listings)
    public function listings() {
        return $this->hasMany(Listing::class);
    }
    
    // Relación directa N:M con Usuarios a través de Listings (Opcional, pero útil)
    public function sellers() {
        return $this->belongsToMany(User::class, 'listings')
                    ->withPivot('price', 'condition', 'is_foil');
    }
}