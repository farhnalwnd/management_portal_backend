<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Traits\indexDirect;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    use indexDirect;

    protected static string $resource = RoleResource::class;

    public array $permissionIds = [];

    protected function mutateFormDataBeforeCreate(array $data): array
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

    protected function afterCreate(): void
    {
        $this->record->syncPermissions($this->permissionIds);
    }
}
