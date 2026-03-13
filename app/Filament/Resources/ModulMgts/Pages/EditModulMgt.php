<?php

namespace App\Filament\Resources\ModulMgts\Pages;

use App\Filament\Resources\ModulMgts\ModulMgtResource;
use App\Traits\indexDirect;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditModulMgt extends EditRecord
{
    use indexDirect;

    protected static string $resource = ModulMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
