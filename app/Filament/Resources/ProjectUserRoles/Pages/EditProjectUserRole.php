<?php

namespace App\Filament\Resources\ProjectUserRoles\Pages;

use App\Filament\Resources\ProjectUserRoles\ProjectUserRoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProjectUserRole extends EditRecord
{
    protected static string $resource = ProjectUserRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
