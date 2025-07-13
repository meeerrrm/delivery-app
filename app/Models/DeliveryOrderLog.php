<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryOrderLog extends Model
{
    protected $fillable = [
        'delivery_order_id',
        'status',
        'note',
        'document',
        'assessed_by',
    ];

    public function deliveryOrder() { return $this->belongsTo(DeliveryOrder::class); }
    public function assessedBy()    { return $this->belongsTo(User::class, 'assessed_by'); }

    public function getDocumentUrlAttribute(): ?string
    {
        return $this->document ? asset('storage/' . $this->document) : null;
    }
}
