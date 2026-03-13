<?php

namespace App\Filament\Resources\MenuMgts\Pages;

use App\Filament\Resources\MenuMgts\MenuMgtResource;
use App\Traits\indexDirect;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMenuMgt extends EditRecord
{
    use indexDirect;

    protected static string $resource = MenuMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
