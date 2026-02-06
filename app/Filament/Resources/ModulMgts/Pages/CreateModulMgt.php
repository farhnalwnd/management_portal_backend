<?php

namespace App\Filament\Resources\ModulMgts\Pages;

use App\Filament\Resources\ModulMgts\ModulMgtResource;
use App\Traits\indexDirect;
use Filament\Resources\Pages\CreateRecord;

class CreateModulMgt extends CreateRecord
{
    use indexDirect;

    protected static string $resource = ModulMgtResource::class;
}
