<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    public array $permissionIds = [];

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'permissions_')) {
                if (is_array($value)) {
                    $this->permissionIds = array_merge($this->permissionIds, $value);
                }
                unset($data[$key]);
            }
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->syncPermissions($this->permissionIds);
    }
}
