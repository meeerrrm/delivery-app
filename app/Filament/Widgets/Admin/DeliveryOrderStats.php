<?php

namespace App\Filament\Widgets\Admin;

use Filament\Widgets\ChartWidget;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeliveryOrderStats extends ChartWidget
{
    protected static ?string $heading = 'Monthly Delivery Order';
    protected static string $color = 'primary'; // warna grafik


    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->hasRole(['Super Admin','Admin']);
    }
    protected function getData(): array
    {
        $data = DeliveryOrder::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $labels = [];
        $values = [];

        foreach (range(1, 12) as $month) {
            $labels[] = \Carbon\Carbon::create()->month($month)->format('F');
            $values[] = $data[$month] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Delivery Order',
                    'data' => $values,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Bisa diganti: 'line', 'pie', 'doughnut'
    }
}
