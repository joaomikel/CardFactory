<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'icon_svg'];
    
    // Un Set tiene muchas Cartas (1:N)
    public function cards() {
        return $this->hasMany(Card::class);
    }
}