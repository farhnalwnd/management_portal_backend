<?php

namespace App\Filament\Resources\ContentMgts\Pages;

use App\Filament\Resources\ContentMgts\ContentMgtResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListContentMgts extends ListRecords
{
    protected static string $resource = ContentMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
