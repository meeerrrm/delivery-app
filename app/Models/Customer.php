<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{

    protected $fillable = [
        'company_name',
        'company_contacts',
        'company_address',
        'industry',
        'logo',
        'user_id'
    ];
    protected $casts = [
        'company_contacts' => 'array',
    ];
    public function deliveryOrders(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class);
    }
    public function companyOwner(): BelongsTo { return $this->belongsTo(User::class,'customer_id'); }

}
