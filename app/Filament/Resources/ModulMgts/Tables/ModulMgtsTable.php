<?php

namespace App\Filament\Resources\ModulMgts\Tables;

use App\Filament\Resources\ModulMgts\ModulMgtResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ModulMgtsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('module_name')
                    ->label('Module Name')
                    ->searchable(),
                TextColumn::make('module_description')
                    ->label('Module Description')
                    ->searchable(),
                TextColumn::make('categoryRelationship.module_slug')
                    ->label('Category')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('creator.first_name')
                    ->label('Creator')
                    ->description(fn ($record) => $record->modifier ? $record->creator->last_name : '')
                    ->sortable(),
                TextColumn::make('modifier.first_name')
                    ->label('Modifier')
                    ->description(fn ($record) => $record->modifier ? $record->modifier->last_name : '')
                    ->sortable(),
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
                    ->label('Active Modules')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),

                SelectFilter::make('category')
                    ->relationship('categoryRelationship', 'module_slug'),
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
            ->emptyStateActions([
                Action::make('create')
                    ->label('Create Module')
                    ->url(fn (): string => ModulMgtResource::getUrl('create'))
                    ->icon('heroicon-m-rectangle-stack')
                    ->button(),
            ])
            ->emptyStateDescription('Belum ada modul terdaftar. Tambahkan modul aplikasi baru.')
            ->recordUrl(null);
    }
}
