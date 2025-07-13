<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryOrder extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'truck_id',
        'driver_id',
        'origin_id',
        'destination_id',
        'items'
    ];
    protected $casts = [
        'items' => 'array',
    ];


    public function customer()      { return $this->belongsTo(Customer::class); }
    public function truck()         { return $this->belongsTo(Truck::class); }
    public function origin()        { return $this->belongsTo(Location::class, 'origin_id'); }
    public function destination()   { return $this->belongsTo(Location::class, 'destination_id'); }

    public function driver()   { return $this->belongsTo(User::class, 'driver_id'); }

    public function logs()          { return $this->hasMany(DeliveryOrderLog::class); }

    public function getCurrentStatusAttribute(): ?string
    {
        return $this->logs()->latest()->first()?->status ?? 'Pending';
    }

}
