<?php

namespace App\Filament\Resources\DeliveryOrderResource\Pages;

use App\Filament\Resources\DeliveryOrderResource;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Infolists\Components\Table;
use Filament\Infolists\Components\ViewEntry;
use Filament\Tables\Columns\TextColumn;

class ViewDeliveryOrder extends ViewRecord
{
    protected static string $resource = DeliveryOrderResource::class;

    protected static function getUser()
    {
        return Auth::user();
    }
    public function getTitle(): string
    {
        return 'Detail Delivery Order: ' . $this->record->order_number;
    }
    protected function getHeaderActions(): array
    {

        $user = Auth::user();

        return [
            ...(static::getUser()->hasRole(['Super Admin', 'Admin', 'Driver']) ?
                [
                    Action::make('addLog')
                    ->label('Tambah Log Baru')
                    ->icon('heroicon-o-plus-circle')
                    ->modalHeading('Tambah Status Log')
                    ->form([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Pending' => 'Pending',
                                'To Origin' => 'To Origin',
                                'Arrival to Origin' => 'Arrival to Origin',
                                'On Load' => 'On Load',
                                'To Destination' => 'To Destination',
                                'Arrival to Destination' => 'Arrival to Destination',
                                'Unload' => 'Unload',
                                'Done' => 'Done',
                            ])
                            ->default(fn () => $this->record->logs->last()?->status ?? 'Pending')
                            ->hint('Pilih status selanjutnya. Status sebelumnya tidak boleh diulang.')
                            ->required(),

                        Textarea::make('note')
                            ->label('Catatan')
                            ->rows(3),

                        FileUpload::make('document')
                            ->label('Dokumen (opsional)')
                            ->directory('delivery-order-logs'),
                    ])
                    ->action(function (array $data) {
                        $statusOrder = [
                            'Pending',
                            'To Origin',
                            'Arrival to Origin',
                            'On Load',
                            'To Destination',
                            'Arrival to Destination',
                            'Unload',
                            'Done',
                        ];

                        $lastStatus = $this->record->logs->last()?->status ?? 'Pending';
                        $newStatus = $data['status'];

                        $lastIndex = array_search($lastStatus, $statusOrder);
                        $newIndex = array_search($newStatus, $statusOrder);

                        if ($newIndex === false || $newIndex <= $lastIndex) {
                            Notification::make()
                                ->title('Gagal Menambahkan Log')
                                ->body('Status tidak boleh mundur atau sama dengan "' . $lastStatus . '".')
                                ->danger()
                                ->persistent()
                                ->send();

                            return;
                        }
                        $this->record->logs()->create([
                            'status' => $data['status'],
                            'note' => $data['note'] ?? null,
                            'document' => $data['document'] ?? null,
                            'assessed_by' => Auth::id(),
                        ]);
                        $this->mount($this->getRecord()->getKey());

                    })
                    ->modalSubmitActionLabel('Simpan')
                ] : []),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Data Delivery Order')->schema([

                    Grid::make(2)
                        ->schema([
                        TextEntry::make('order_number')
                            ->label('Order Number'),
                        TextEntry::make('customer.company_name')
                            ->label('Customer Name'),

                    ]),
                ]),
                Grid::make(2)
                    ->schema([

                        ComponentsSection::make('Data Truk dan Driver')->schema([
                            Grid::make(3)
                                ->schema([
                                    TextEntry::make('driver.name')->label('Nama Driver'),
                                    TextEntry::make('driver.phone_number')->label('Nomor Telepon Driver'),
                                    TextEntry::make('driver.email')->label('Email Driver'),
                                    TextEntry::make('truck_info')
                                        ->label('Truck')
                                        ->state(function($record){
                                            $truck = $record->truck;
                                            return $truck ? "{$truck->brand} {$truck->model}" : 'Error';
                                        }),
                                    TextEntry::make('truck.truckType.name')->label('Truck Type'),
                                ]),

                        ]),
                        ComponentsSection::make('Data Lokasi')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Group::make()
                                        ->relationship('origin')
                                        ->schema([
                                            TextEntry::make('place_name')
                                                ->label('Lokasi Asal'),
                                            TextEntry::make('origin_map')
                                                ->label('Map Asal')
                                                ->state(fn ($record) => "Lihat di Google Maps")
                                                ->url(fn ($record) => "https://www.google.com/maps?q={$record->origin->lat},{$record->origin->long}")
                                                ->openUrlInNewTab()
                                                ->copyable()
                                                ->icon('heroicon-o-map-pin')
                                                ->color('primary'),
                                        ]),

                                    Group::make()
                                        ->relationship('destination')
                                        ->schema([
                                            TextEntry::make('place_name')
                                                ->label('Lokasi Tujuan'),
                                            TextEntry::make('map_link')
                                                ->label('Map Tujuan')
                                                ->url(fn ($record) => "https://www.google.com/maps?q={$record->destination->lat},{$record->destination->long}")
                                                ->openUrlInNewTab()
                                                ->state(fn ($record) => "Lihat di Google Maps")
                                                ->copyable()
                                                ->icon('heroicon-o-map-pin')
                                                ->color('primary'),
                                        ]),
                                ]),
                            ]),
                    ]),
                    ComponentsSection::make('Items Load')->schema([

                        ViewEntry::make('items')
                            ->view('filament.infolists.delivery-order.items-table')
                            ->visible(fn ($state) => filled($state)),
                    ]),

            ]);
    }

}
