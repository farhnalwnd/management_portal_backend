<?php

namespace App\Filament\Resources\ProjectUserRoles\Pages;

use App\Filament\Resources\ProjectUserRoles\ProjectUserRoleResource;
use App\Models\ProjectUserRole;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProjectUserRole extends CreateRecord
{
    protected static string $resource = ProjectUserRoleResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $userIds = $data['user_id'] ?? [];
        $moduleId = $data['module_id'];
        $roleId = $data['role_id'];

        // If for some reason it's not an array, cast it to one
        if (! is_array($userIds)) {
            $userIds = [$userIds];
        }

        $firstRecord = null;

        foreach ($userIds as $userId) {
            $record = ProjectUserRole::updateOrCreate(
                [
                    'module_id' => $moduleId,
                    'user_id' => $userId,
                ],
                [
                    'role_id' => $roleId,
                ]
            );

            // Keep the first record as the return result for Filament's internal process
            if (! $firstRecord) {
                $firstRecord = $record;
            }
        }

        // Return the first record, or generic new instance if empty (shouldn't happen with validation)
        return $firstRecord ?? new ProjectUserRole;
    }
}
