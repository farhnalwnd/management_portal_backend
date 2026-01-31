<?php

namespace App\Filament\Resources\ModulMgts\Pages;

use App\Filament\Resources\ModulMgts\ModulMgtResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewModulMgt extends ViewRecord
{
    protected static string $resource = ModulMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
