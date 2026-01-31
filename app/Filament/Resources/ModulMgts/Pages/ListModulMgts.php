<?php

namespace App\Filament\Resources\ModulMgts\Pages;

use App\Filament\Resources\ModulMgts\ModulMgtResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListModulMgts extends ListRecords
{
    protected static string $resource = ModulMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
