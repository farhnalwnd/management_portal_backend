<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Traits\indexDirect;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    use indexDirect;

    protected static string $resource = RoleResource::class;
}
