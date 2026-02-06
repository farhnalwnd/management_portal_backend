<?php

namespace App\Filament\Resources\MenuMgts\Pages;

use App\Filament\Resources\MenuMgts\MenuMgtResource;
use App\Traits\indexDirect;
use Filament\Resources\Pages\CreateRecord;

class CreateMenuMgt extends CreateRecord
{
    use indexDirect;
    protected static string $resource = MenuMgtResource::class;
}
