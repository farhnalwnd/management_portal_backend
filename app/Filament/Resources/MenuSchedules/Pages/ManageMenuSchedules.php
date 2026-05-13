<?php

namespace App\Filament\Resources\MenuSchedules\Pages;

use App\Filament\Resources\MenuSchedules\MenuScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMenuSchedules extends ManageRecords
{
    protected static string $resource = MenuScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('xl'),
        ];
    }
}
