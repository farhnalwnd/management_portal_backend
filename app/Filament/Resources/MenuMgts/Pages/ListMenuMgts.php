<?php

namespace App\Filament\Resources\MenuMgts\Pages;

use App\Filament\Resources\MenuMgts\MenuMgtResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\ListRecords;

class ListMenuMgts extends ListRecords
{
    protected static string $resource = MenuMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
