<?php

namespace App\Filament\Resources\ModulMgts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
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
                    ->searchable(),
                TextColumn::make('module_description')
                    ->searchable(),
                TextColumn::make('category')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'fico' => 'heroicon-m-banknotes',
                        'mm'   => 'heroicon-m-cube',
                        'sd'   => 'heroicon-m-shopping-cart',
                        'pp'   => 'heroicon-m-cog',
                        'pm'   => 'heroicon-m-wrench',
                        'hr'   => 'heroicon-m-user-group',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'fico' => 'success', // Hijau
                        'mm'   => 'warning', // Oranye
                        'sd'   => 'info',    // Biru Muda
                        'pp'   => 'danger',  // Merah
                        'pm'   => 'gray',    // Abu-abu
                        'hr'   => 'primary', // Biru Tua
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'fico' => 'Finance & Controlling',
                        'mm'   => 'Materials Management',
                        'sd'   => 'Sales & Distribution',
                        'pp'   => 'Production Planning',
                        'pm'   => 'Plant Maintenance',
                        'hr'   => 'Human Capital Management',
                        default => $state,
                    }),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                TextColumn::make('creator.first_name')
                    ->description(fn($record) => $record->modifier ? $record->creator->last_name : '')
                    ->sortable(),
                TextColumn::make('modifier.first_name')
                    ->description(fn($record) => $record->modifier ? $record->modifier->last_name : '')
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
                    ->query(fn(Builder $query): Builder => $query->where('is_active', true)),

                SelectFilter::make('category')
                    ->options([
                        'fico' => 'Finance & Controlling',
                        'mm'   => 'Materials Management',
                        'sd'   => 'Sales & Distribution',
                        'pp'   => 'Production Planning',
                        'pm'   => 'Plant Maintenance',
                        'hr'   => 'Human Capital Management',
                    ])
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
