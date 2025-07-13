<?php
namespace App\Filament\Widgets\Customer;

use App\Models\DeliveryOrder;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderLogStats extends ChartWidget
{
    protected static ?string $heading = 'Delivery Order Status (Last 30 Days)';
    protected int | string | array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line'; // atau 'line'
    }

    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->hasRole(['Customer']);
    }

    protected function getData(): array
    {
        $statusColorMap = [
            'Pending' => 'rgb(148, 163, 184)',
            'To Origin' => 'rgb(59, 130, 246)',
            'Arrival to Origin' => 'rgb(56, 189, 248)',
            'On Load' => 'rgb(251, 113, 133)',
            'To Destination' => 'rgb(59, 130, 246)',
            'Arrival to Destination' => 'rgb(56, 189, 248)',
            'Unload' => 'rgb(251, 113, 133)',
            'Done' => 'rgb(132, 204, 22)',
        ];

        $statuses = array_keys($statusColorMap);
        $days = 30;

        $labels = [];
        $statusCountsPerDay = [];

        foreach ($statuses as $status) {
            $statusCountsPerDay[$status] = [];
        }

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('d M');

            $deliveryOrders = DeliveryOrder::with(['logs' => function ($query) {
                $query->latest('created_at');
            }])
            ->whereDate('created_at', $date)
            ->where('customer_id',Auth::user()->company->id)
            ->get();

            $dailyStatusCounts = array_fill_keys($statuses, 0);

            foreach ($deliveryOrders as $do) {
                $latestStatus = $do->logs->first()?->status ?? 'Pending';
                if (in_array($latestStatus, $statuses)) {
                    $dailyStatusCounts[$latestStatus]++;
                }
            }

            foreach ($statuses as $status) {
                $statusCountsPerDay[$status][] = $dailyStatusCounts[$status];
            }
        }

        $datasets = [];
        foreach ($statuses as $status) {
            $datasets[] = [
                'label' => $status,
                'data' => $statusCountsPerDay[$status],
                'borderColor' => $statusColorMap[$status],
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }
}
