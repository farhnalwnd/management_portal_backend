<?php

namespace App\Filament\Resources\ContentMgts\Pages;

use App\Filament\Resources\ContentMgts\ContentMgtResource;
use App\Traits\indexDirect;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditContentMgt extends EditRecord
{
    use indexDirect;

    protected static string $resource = ContentMgtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
