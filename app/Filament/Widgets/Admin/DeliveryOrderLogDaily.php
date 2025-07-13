<?php

namespace App\Filament\Widgets\Admin;

use App\Models\DeliveryOrderLog;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderLogDaily extends ChartWidget
{
    protected static ?string $heading = 'Daily Delivery Order Log';
    // protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $statusColorMap = [
            'Pending' => 'rgb(148, 163, 184)', // gray (Zinc-400)
            'To Origin' => 'rgb(59, 130, 246)', // custom-primary (Blue-500)
            'Arrival to Origin' => 'rgb(56, 189, 248)', // custom-info (Sky-400)
            'On Load' => 'rgb(251, 113, 133)', // custom-danger (Rose-400)
            'To Destination' => 'rgb(59, 130, 246)', // custom-primary (Blue-500)
            'Arrival to Destination' => 'rgb(56, 189, 248)', // custom-info (Sky-400)
            'Unload' => 'rgb(251, 113, 133)', // custom-danger (Rose-400)
            'Done' => 'rgb(132, 204, 22)', // custom-success (Lime-500)
        ];

        $days = 7;
        $statuses = [
            'Pending',
            'To Origin',
            'Arrival to Origin',
            'On Load',
            'To Destination',
            'Arrival to Destination',
            'Unload',
            'Done',
        ];

        $labels = [];
        $datasetByStatus = [];

        // Inisialisasi dataset per status
        foreach ($statuses as $status) {
            $datasetByStatus[$status] = [];
        }

        // Ambil data per hari
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::today()->subDays($i)->format('d M');

            $logs = DeliveryOrderLog::whereDate('created_at', $date)
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            foreach ($statuses as $status) {
                $datasetByStatus[$status][] = $logs[$status] ?? 0;
            }
        }

        $datasets = [];
        foreach ($statuses as $status) {
            $datasets[] = [
                'label' => $status,
                'data' => $datasetByStatus[$status],
                'borderColor' => $statusColorMap[$status] ?? 'rgb(0,0,0)',
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Bisa diganti jadi 'bar' kalau mau stacked
    }

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->hasRole(['Super Admin','Admin']);
    }
}
