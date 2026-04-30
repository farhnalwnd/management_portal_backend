<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\department;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Identity')
                    ->columns(3)
                    ->components([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nik')
                            ->required()
                            ->numeric()
                            ->length(16)
                            ->unique()
                            ->regex('/^[0-9]{16}$/'),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->unique()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                    ])->columnSpan(2),

                Section::make('Details')
                    ->components([
                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->options(department::query()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('status')
                            ->options(['active' => 'Active', 'inactive' => 'Inactive', 'locked' => 'Locked'])
                            ->default('active')
                            ->required(),
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->searchable()
                            ->native(false)
                            ->required(),
                    ])->columnSpan(1),
            ]);
    }
}
