<?php

namespace App\Filament\Resources\ContentMgts\Pages;

use App\Filament\Resources\ContentMgts\ContentMgtResource;
use App\Traits\indexDirect;
use Filament\Resources\Pages\CreateRecord;

class CreateContentMgt extends CreateRecord
{
    use indexDirect;

    protected static string $resource = ContentMgtResource::class;
}
