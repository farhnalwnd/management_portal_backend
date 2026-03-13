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
                Select::make('approver_id')
                    ->label('Approver Name')
                    ->relationship('approver', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name'])
                    ->required(),
                TextInput::make('level')
                    ->validationMessages([
                        'unique' => 'The level has already been taken.',
                    ])
                    ->unique('approval_masters', 'level', ignoreRecord: true)
                    ->required()
                    ->numeric(),
            ]);
    }
}
