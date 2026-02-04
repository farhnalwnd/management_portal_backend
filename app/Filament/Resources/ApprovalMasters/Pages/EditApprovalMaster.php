<?php

namespace App\Filament\Resources\ApprovalMasters\Pages;

use App\Filament\Resources\ApprovalMasters\ApprovalMasterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditApprovalMaster extends EditRecord
{
    protected static string $resource = ApprovalMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
