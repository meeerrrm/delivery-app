<?php
namespace App\Support;

class StatusColor
{
    public static function color(string $status): string
    {
        $status = strtolower(trim($status)); // Normalisasi
        return match ($status) {
            'pending' => 'gray',
            'to origin' => 'custom-primary',
            'arrival to origin' => 'custom-info',
            'on load' => 'custom-danger',
            'to destination' => 'custom-primary',
            'arrival to destination' => 'custom-info',
            'unload' => 'custom-danger',
            'done' => 'custom-success',
            default => 'gray',
        };
    }
}
