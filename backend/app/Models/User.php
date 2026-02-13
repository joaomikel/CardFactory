<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname', // <--- NUEVO
        'email',
        'password',
        'phone',   // <--- NUEVO
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
    public function cards()
    {
        return $this->belongsToMany(Card::class, 'listings', 'user_id', 'card_id')
                    ->withPivot('id', 'price', 'quantity', 'condition', 'language', 'is_foil') // Campos extra de la tabla listings
                    ->withTimestamps();
    }
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
