<?php

namespace App\Filament\Resources\ApprovalMasters\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ApprovalMasterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('approver.first_name')
                    ->label('Approver Name')
                    ->options(User::query()->pluck('first_name', 'id'))
                    // ->validationMessages([
                    //     'unique' => 'The approver has already been taken.',
                    // ])
                    // ->unique('approval_masters','approver_id', ignoreRecord: true)
                    ->required(),
                TextInput::make('level')
                    ->validationMessages([
                        'unique' => 'The level has already been taken.',
                    ])
                    ->unique('approval_masters','level', ignoreRecord: true)
                    ->required()
                    ->numeric(),
            ]);
    }
}
