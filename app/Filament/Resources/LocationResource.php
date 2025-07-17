<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;
    protected static ?string $navigationGroup = 'Location Management';
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function canViewAny(): bool
    {
        return Auth::user()->hasRole(['Super Admin','Admin']);
    }
    public static function form(Form $form): Form
    {

        return $form->schema([
            TextInput::make('place_name')->label('Nama Lokasi')->required(),
            TextInput::make('lat')->label('Latitude')->numeric()->required(),
            TextInput::make('long')->label('Longitude')->numeric()->required(),
            Repeater::make('contacts')
                ->label('Kontak Lokasi')
                ->schema([
                    TextInput::make('name')->label('Nama')->required(),
                    TextInput::make('position')->label('Jabatan')->required(),
                    TextInput::make('phone')->label('No. Telepon')->tel()->required(),
                ])
                ->addActionLabel('Tambah Kontak')
                ->collapsible()
                ->grid(2)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('place_name')->label('Lokasi'),
                TextColumn::make('google_maps_url')
                    ->label('Maps')
                    ->url(fn ($record) => $record->google_maps_url, true)
                    ->openUrlInNewTab()
                    ->copyable()
                    ->color('primary')
                    ->icon('heroicon-o-map-pin'),

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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
