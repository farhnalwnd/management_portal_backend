<?php

namespace App\Filament\Resources\ContentMgts\Pages;

use App\Filament\Resources\ContentMgts\ContentMgtResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContentMgt extends ViewRecord
{
    protected static string $resource = ContentMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
