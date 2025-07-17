<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TruckResource\Pages;
use App\Models\Truck;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;
    protected static ?string $navigationGroup = 'Truck Management';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function canViewAny(): bool
    {
        return Auth::user()->hasRole(['Super Admin','Admin']);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('brand')->required()->label('Merek Truk'),
                TextInput::make('model')->required()->label('Model Truk'),
                TextInput::make('year')->numeric()->required()->label('Tahun'),
                TextInput::make('police_number')->required()->label('Nomor Polisi'),

                Select::make('truck_type_id')
                    ->label('Tipe Truk')
                    ->relationship('truckType', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),

                FileUpload::make('kir_document')
                    ->label('Dokumen KIR')
                    ->directory('kir-documents'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('brand'),
                TextColumn::make('model'),
                TextColumn::make('police_number')->label('TNKB'),
                TextColumn::make('truckType.name')->label('Tipe Truk'),
                TextColumn::make('year'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrucks::route('/'),
            'create' => Pages\CreateTruck::route('/create'),
            'edit' => Pages\EditTruck::route('/{record}/edit'),
        ];
    }
}
