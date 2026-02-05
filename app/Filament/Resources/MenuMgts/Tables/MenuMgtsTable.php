<?php

namespace App\Filament\Resources\MenuMgts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MenuMgtsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('menu_name')
                    ->label('Menu Name')
                    ->searchable(),
                TextColumn::make('modul_mgt.module_name')
                    ->label('Module')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('content_mgt.title')
                    ->label('Content')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('display_order')
                    ->label('Display Order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            Filter::make('is_active')
                ->label('Active Menus')
                ->query(fn(Builder $query): Builder => $query->where('is_active', true))
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null);
    }
}
