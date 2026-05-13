<?php

namespace App\Filament\Resources\MdModuleCategories\Pages;

use App\Filament\Resources\MdModuleCategories\MdModuleCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMdModuleCategories extends ListRecords
{
    protected static string $resource = MdModuleCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
