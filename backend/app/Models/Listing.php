<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'card_id',      // Relación con tu tabla cards interna
            'scryfall_id',  // <--- IMPORTANTE: Para que MagicSeeder funcione
            'price',
            'quantity',
            'condition',
            'language',
            'is_foil',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function card() {
        return $this->belongsTo(Card::class);
    }
}