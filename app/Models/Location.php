<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'place_name',
        'contacts',
        'lat',
        'long',
    ];

    protected $casts = [
        'contacts'=>'array',
        'lat' => 'float',
        'long' => 'float',
    ];

    // Relasi ke delivery order sebagai asal
    public function originOrders(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class, 'origin_id');
    }

    // Relasi ke delivery order sebagai tujuan
    public function destinationOrders(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class, 'destination_id');
    }

    // Getter lokasi singkat
    public function getCoordinatesAttribute(): string
    {
        return "{$this->lat}, {$this->long}";
    }
    public function getGoogleMapsUrlAttribute(): string
{
    return "https://www.google.com/maps?q={$this->lat},{$this->long}";
}

}
