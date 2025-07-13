<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Truck extends Model
{
        protected $fillable = [
        'brand',
        'model',
        'year',
        'police_number',
        'truck_type_id',
        'kir_document',
    ];

    /**
     * Relasi ke TruckType
     */
    public function truckType(): BelongsTo
    {
        return $this->belongsTo(TruckType::class);
    }

    public function deliveryOrders(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    /**
     * Dapatkan URL file KIR
     */
    public function getKirUrlAttribute(): ?string
    {
        return $this->kir_document
            ? asset('storage/' . $this->kir_document)
            : null;
    }
}
