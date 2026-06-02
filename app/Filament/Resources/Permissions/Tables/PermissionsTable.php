<?php

namespace App\Filament\Resources\Permissions\Tables;

use App\Filament\Resources\Permissions\PermissionResource;
use App\Models\MdModuleCategory;
use App\Models\ModulMgt;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                    ->badge(fn ($record): bool => $record?->module_id === null)
                    ->color(fn ($record): string => $record?->module_id === null ? 'info' : 'gray')
                    ->state(fn ($record): string => $record->modulMgt?->module_name ?? 'Global'),

                TextColumn::make('modulMgt.categoryRelationship.module_slug')
                    ->label('SAP Category')
                    ->badge()
                    ->default('Portal System')
                    ->icon(fn ($record): string => $record->modulMgt?->categoryRelationship?->icon ?? 'heroicon-m-cog-6-tooth')
                    ->color(fn ($record): string => $record->modulMgt?->categoryRelationship?->color ?? 'gray')
                    ->sortable()
                    ->searchable(),

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
                SelectFilter::make('category')
                    ->label('SAP Category')
                    ->options(
                        MdModuleCategory::query()
                            ->pluck('module_slug', 'id')
                            ->toArray()
                    )
                    ->query(fn ($query, array $data) => $data['value']
                        ? $query->whereHas('modulMgt', fn ($q) => $q->where('category', $data['value']))
                        : $query),

                SelectFilter::make('module_id')
                    ->label('Module')
                    ->options(ModulMgt::query()->where('is_active', true)->pluck('module_name', 'id'))
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Create Permission')
                    ->url(fn (): string => PermissionResource::getUrl('create'))
                    ->icon('heroicon-m-key')
                    ->button(),
            ])
            ->emptyStateDescription('Belum ada permission. Buat permission baru untuk mengontrol akses.')
            ->recordUrl(null);
    }
}
