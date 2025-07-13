<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TruckType extends Model
{
    protected $fillable = [
        'code',
        'name',
        'ton_capacity',
        'length',
        'width',
        'height',
    ];
    /**
     * Relasi ke model Truck
     */
    public function trucks(): HasMany
    {
        return $this->hasMany(Truck::class);
    }

    /**
     * Menampilkan dimensi sebagai string
     */
    public function getDimensionAttribute(): string
    {
        $length = number_format($this->length / 100, 1);
        $width  = number_format($this->width / 100, 1);
        $height = number_format($this->height / 100, 1);

        return "{$length} x {$width} x {$height} m";
    }
}
