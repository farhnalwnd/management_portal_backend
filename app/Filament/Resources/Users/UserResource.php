<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Dom\Text;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'User';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    // public static function infolist(Schema $schema): Schema
    // {
    //     return UserInfolist::configure($schema);
    // }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('User Information')
                    ->columns(3)
                    ->schema([
                    Section::make('Identity')
                        ->schema([
                            TextEntry::make('full_name')
                                ->label('Full Name')
                                ->state(fn($record): string => $record->first_name . ' ' . $record->last_name),

                            TextEntry::make('nik')
                                ->label('NIK'),

                            TextEntry::make('email')
                                ->label('Email Address'),
                        ])
                        ->columns(1)
                        ->columnSpan(2),

                    Section::make('Details')
                        ->schema([
                            TextEntry::make('department.name')
                                ->label('Department'),

                            TextEntry::make('status')
                                ->badge()
                                ->color(fn(string $state): string => match ($state) {
                                    'active' => 'success',
                                    'inactive' => 'warning',
                                    'locked' => 'danger',
                                    default => 'gray',
                                }),

                            TextEntry::make('roles.name')
                                ->label('Roles')
                                ->default('No Role Assigned')
                                ->badge()
                                ->color('info'),
                        ])
                        ->columnSpan(1),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
            // 'view' => ViewUser::route('/{record}'),
        ];
    }
}
