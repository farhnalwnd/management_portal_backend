<?php

namespace App\Filament\Resources\ModulMgts\Pages;

use App\Filament\Resources\ModulMgts\ModulMgtResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditModulMgt extends EditRecord
{
    protected static string $resource = ModulMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
