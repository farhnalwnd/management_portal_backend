<?php

namespace App\Filament\Resources\ApprovalMasters\Pages;

use App\Filament\Resources\ApprovalMasters\ApprovalMasterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApprovalMasters extends ListRecords
{
    protected static string $resource = ApprovalMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
