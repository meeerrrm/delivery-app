<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TruckTypeResource\Pages;
use App\Filament\Resources\TruckTypeResource\RelationManagers;
use App\Models\TruckType;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TruckTypeResource extends Resource
{
    protected static ?string $model = TruckType::class;
    protected static ?string $navigationGroup = 'Truck Management';
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function canViewAny(): bool
    {
        return Auth::user()->hasRole(['Super Admin','Admin']);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->required()
                    ->unique()
                    ->label('Kode Tipe'),

                TextInput::make('name')
                    ->required()
                    ->label('Nama Tipe Truk'),

                TextInput::make('ton_capacity')
                    ->numeric()
                    ->required()
                    ->label('Kapasitas (Ton)'),

                TextInput::make('length')->numeric()->required()->label('Panjang (cm)'),
                TextInput::make('width')->numeric()->required()->label('Lebar (cm)'),
                TextInput::make('height')->numeric()->required()->label('Tinggi (cm)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code'),
                TextColumn::make('name'),
                TextColumn::make('ton_capacity')->label('Tonase'),
                TextColumn::make('dimension')
                    ->label('Dimensi (P x L x T)')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListTruckTypes::route('/'),
            'create' => Pages\CreateTruckType::route('/create'),
            'edit' => Pages\EditTruckType::route('/{record}/edit'),
        ];
    }
}
