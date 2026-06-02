<?php

namespace App\Filament\Resources\AuditActivities\Pages;

use App\Filament\Resources\AuditActivities\AuditActivityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuditActivity extends CreateRecord
{
    protected static string $resource = AuditActivityResource::class;

    protected static bool $canCreateAnother = false;

    public function canCreate(): bool
    {
        return false;
    }
}
