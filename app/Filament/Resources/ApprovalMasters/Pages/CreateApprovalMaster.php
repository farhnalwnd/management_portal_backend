<?php

namespace App\Filament\Resources\ApprovalMasters\Pages;

use App\Filament\Resources\ApprovalMasters\ApprovalMasterResource;
use App\Traits\indexDirect;
use Filament\Resources\Pages\CreateRecord;

class CreateApprovalMaster extends CreateRecord
{
    use indexDirect;

    protected static string $resource = ApprovalMasterResource::class;
}
