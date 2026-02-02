<?php

namespace App\Filament\Resources\MenuMgts\Pages;

use App\Filament\Resources\MenuMgts\MenuMgtResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMenuMgt extends EditRecord
{
    protected static string $resource = MenuMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
