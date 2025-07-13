<?php

namespace App\Filament\Resources\DeliveryOrderResource\RelationManagers;

use App\Support\StatusColor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogsRelationManager extends RelationManager
{
    protected static string $relationship = 'logs';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')->badge()->color(fn (string $state) => StatusColor::color($state)),
                TextColumn::make('note')->label('Keterangan'),
                ImageColumn::make('document')->label('Document')->visibility('private'),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i'),
                TextColumn::make('assessedBy.name')->label('Dibuat oleh'),
            ]);
    }
}
