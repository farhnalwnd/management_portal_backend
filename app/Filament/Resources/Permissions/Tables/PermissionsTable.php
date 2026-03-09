<?php

namespace App\Filament\Resources\Permissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PermissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Permission Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('modulMgt.module_name')
                    ->label('Module')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info')
                    ->state(fn ($record) => $record->modulMgt ? "{$record->modulMgt->module_name}" : 'Global'),
                TextColumn::make('guard_name')
                    ->label('Guard')
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
