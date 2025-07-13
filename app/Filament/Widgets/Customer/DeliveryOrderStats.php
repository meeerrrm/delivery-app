<?php

namespace App\Filament\Widgets\Customer;

use App\Models\Customer;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Truck;
use App\Models\TruckType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderStats extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return Auth::check() && Auth::user()->hasRole(['Customer']);
    }
    protected function getCards(): array
    {

        $deliveryOrders = DeliveryOrder::with(['logs' => fn($query) => $query->latest()])->where('customer_id',Auth::user()->company->id)
            ->get();

        $statusCounts = $deliveryOrders
            ->map(fn ($do) => $do->logs->first()?->status)
            ->filter()
            ->countBy(); // hitung jumlah masing-masing status

        return [

            Stat::make('Total Delivery Order', $deliveryOrders->count()),
            Stat::make('Delivery Order Pending', $statusCounts->get('Pending', 0)),
            Stat::make('Delivery Order On Progress', $statusCounts->except(['Pending', 'Done'])->sum()),
            Stat::make('Delivery Order Selesai', $statusCounts->get('Done', 0)),
        ];
    }
}
