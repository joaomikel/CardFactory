<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'scryfall_id', 
        'image_url', 
        'rarity', 
        'set_id'
    ];

    // Relación con el Set 
    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    // Relación con los Listings
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function sellers()
    {
        return $this->belongsToMany(User::class, 'listings', 'card_id', 'user_id')
                    ->withPivot('id', 'price', 'quantity', 'condition', 'language', 'is_foil')
                    ->withTimestamps();
    }
}