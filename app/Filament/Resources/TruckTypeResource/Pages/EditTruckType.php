<?php

namespace App\Filament\Resources\TruckTypeResource\Pages;

use App\Filament\Resources\TruckTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTruckType extends EditRecord
{
    protected static string $resource = TruckTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
