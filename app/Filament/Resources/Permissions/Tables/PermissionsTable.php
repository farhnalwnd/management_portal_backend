<?php

namespace App\Filament\Resources\Permissions\Tables;

use App\Filament\Resources\Permissions\PermissionResource;
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
    /** @var array<string, string> */
    private const CATEGORY_LABELS = [
        'fico' => 'Finance & Controlling',
        'mm' => 'Materials Management',
        'sd' => 'Sales & Distribution',
        'pp' => 'Production Planning',
        'pm' => 'Plant Maintenance',
        'hr' => 'Human Capital Management',
    ];

    /** @var array<string, string> */
    private const CATEGORY_ICONS = [
        'fico' => 'heroicon-m-banknotes',
        'mm' => 'heroicon-m-cube',
        'sd' => 'heroicon-m-shopping-cart',
        'pp' => 'heroicon-m-cog',
        'pm' => 'heroicon-m-wrench',
        'hr' => 'heroicon-m-user-group',
    ];

    /** @var array<string, string> */
    private const CATEGORY_COLORS = [
        'fico' => 'success',
        'mm' => 'warning',
        'sd' => 'info',
        'pp' => 'danger',
        'pm' => 'gray',
        'hr' => 'primary',
    ];

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

                TextColumn::make('modulMgt.category')
                    ->label('SAP Category')
                    ->badge()
                    ->default('nan')
                    ->icon(fn (?string $state): string => self::CATEGORY_ICONS[$state ?? ''] ?? 'heroicon-m-cog-6-tooth')
                    ->color(fn (?string $state): string => self::CATEGORY_COLORS[$state ?? ''] ?? 'gray')
                    ->formatStateUsing(fn (?string $state): string => self::CATEGORY_LABELS[$state ?? ''] ?? 'portal system')
                    ->sortable(),

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
                    ->options(self::CATEGORY_LABELS)
                    ->query(fn ($query, array $data) => $data['value']
                        ? $query->whereHas('modulMgt', fn ($q) => $q->where('category', $data['value']))
                        : $query),

                SelectFilter::make('module_id')
                    ->label('Module')
                    ->options(ModulMgt::where('is_active', true)->pluck('module_name', 'id'))
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
