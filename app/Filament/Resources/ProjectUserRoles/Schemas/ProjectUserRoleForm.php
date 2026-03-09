<?php

namespace App\Filament\Resources\ProjectUserRoles\Schemas;

use App\Models\ModulMgt;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class ProjectUserRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('module_id')
                    ->label('Module')
                    ->options(ModulMgt::query()->pluck('module_name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('user_id')
                    ->label('Users')
                    ->options(User::query()->get()->pluck('full_name', 'id'))
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required()
                    ->visibleOn('create'),
                Select::make('user_id')
                    ->label('User')
                    ->options(User::query()->get()->pluck('full_name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->visibleOn('edit'),
                Select::make('role_id')
                    ->label('Role')
                    ->options(Role::query()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
