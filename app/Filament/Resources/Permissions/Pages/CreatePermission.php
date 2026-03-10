<?php

namespace App\Filament\Resources\Permissions\Pages;

use App\Filament\Resources\Permissions\PermissionResource;
use App\Traits\indexDirect;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    use indexDirect;

    protected static string $resource = PermissionResource::class;

    /**
     * Concatenate the structured inputs into the standard module:feature:action format
     * before the record is persisted to the database.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] = implode(':', [
            $data['module_name'],
            $data['feature'],
            $data['action'],
        ]);

        unset($data['module_name'], $data['feature'], $data['action']);

        return $data;
    }
}
