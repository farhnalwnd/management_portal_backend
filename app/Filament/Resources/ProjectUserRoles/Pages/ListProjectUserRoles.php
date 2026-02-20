<?php

namespace App\Filament\Resources\ProjectUserRoles\Pages;

use App\Filament\Resources\ProjectUserRoles\ProjectUserRoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProjectUserRoles extends ListRecords
{
    protected static string $resource = ProjectUserRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
