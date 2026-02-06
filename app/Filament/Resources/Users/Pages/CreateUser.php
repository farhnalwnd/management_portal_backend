<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Traits\indexDirect;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    use indexDirect;
    protected static string $resource = UserResource::class;
}
