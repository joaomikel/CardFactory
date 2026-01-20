<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'scryfall_id', 'price', 'condition', 'language', 'is_foil', 'quantity'];

    // ESTA ES LA RELACIÓN ("Una venta pertenece a un usuario")
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}