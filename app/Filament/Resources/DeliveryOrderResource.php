<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryOrderResource\Pages;
use App\Filament\Resources\DeliveryOrderResource\RelationManagers\LogsRelationManager;
use App\Models\DeliveryOrder;
use App\Support\StatusColor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderResource extends Resource
{
    protected static ?string $model = DeliveryOrder::class;
    protected static ?string $navigationGroup = 'Delivery Management';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static function getUser()
    {
        return Auth::user();
    }

    public static function canCreate(): bool
    {
        return Auth::user()->hasRole(['Super Admin','Admin']);
    }
    public static function canEdit(Model $record): bool
    {
        return Auth::user()->hasRole(['Super Admin','Admin']);
    }

    public static function getEloquentQuery(): Builder
    {
        if (static::getUser()->hasRole('driver')) {
            return parent::getEloquentQuery()->where('driver_id', static::getUser()->id);
        }

        if (static::getUser()->hasRole('customer')) {
            return parent::getEloquentQuery()->where('customer_id', static::getUser()->customer->id);
        }

        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            TextInput::make('order_number')
                ->required()
                ->label('Order Number')
                ->unique(
                    table: 'delivery_orders',
                    column: 'order_number',
                    ignorable: fn ($record) => $record,
                ),
                Select::make('customer_id')
                    ->relationship('customer', 'company_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('truck_id')
                    ->label('Truk')
                    ->options(function () {
                        return \App\Models\Truck::with('truckType')
                            ->get()
                            ->mapWithKeys(function ($truck) {
                                $label = "{$truck->brand} {$truck->model} - {$truck->truckType->name} - {$truck->police_number}";
                                return [$truck->id => $label];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->required(),
                Select::make('driver_id')
                    ->label('Pengemudi')
                    ->options(function () {
                        return \App\Models\User::role('Driver')
                            ->get()
                            ->mapWithKeys(function ($user) {
                                $label = "{$user->name} - {$user->phone_number}";
                                return [$user->id => $label];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->required(),
                Select::make('origin_id')
                    ->relationship('origin', 'place_name')
                    ->searchable()
                    ->label('Lokasi Asal')
                    ->preload()
                    ->required(),
                Select::make('destination_id')
                    ->relationship('destination', 'place_name')
                    ->searchable()
                    ->label('Lokasi Tujuan')
                    ->preload()
                    ->required(),

            Repeater::make('items')
                ->label('Detail Barang')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Barang')
                        ->required()
                        ->columnSpan(1),

                    TextInput::make('type')
                        ->label('Jenis Barang')
                        ->required()
                        ->columnSpan(1),

                    TextInput::make('quantity')
                        ->label('Jumlah')
                        ->numeric()
                        ->required()
                        ->columnSpan(1),
                ])
                ->grid(3) // Bikin tampil seperti tabel
                ->addActionLabel('Tambah Barang')
                ->defaultItems(1)
                ->columnSpanFull()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->searchable(),
                TextColumn::make('customer.company_name')->label('Customer'),
                TextColumn::make('truck')->label('Truck')->formatStateUsing(function ($state) {
                        return "{$state->brand} {$state->model} - {$state->police_number}";
                    }),
                TextColumn::make('destination.place_name')->label('Tujuan'),
                TextColumn::make('current_status')->label('Status')->badge()->color(fn (string $state) => StatusColor::color($state)),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                ...(static::getUser()->hasRole(['Super Admin', 'Admin', 'Driver'])) ? [
                    Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => optional($record->logs->last())->status === null || optional($record->logs->last())->status === 'Pending' || Static::getUser()->HasRole('Super Admin'))
                 ] : [],
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            LogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryOrders::route('/'),
            'create' => Pages\CreateDeliveryOrder::route('/create'),
            'edit' => Pages\EditDeliveryOrder::route('/{record}/edit'),
            'view' => Pages\ViewDeliveryOrder::route('/{record}'),
        ];
    }

}
