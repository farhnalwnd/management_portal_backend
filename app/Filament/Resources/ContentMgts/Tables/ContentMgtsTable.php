<?php

namespace App\Filament\Resources\ContentMgts\Tables;

use App\Filament\Resources\ContentMgts\ContentMgtResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContentMgtsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('module.module_name')
                    ->sortable(),
                TextColumn::make('version')
                    ->searchable(),
                IconColumn::make('status')
                    ->label('Is Active')
                    ->boolean(),
                TextColumn::make('repo')
                    ->searchable(),
                TextColumn::make('creator.first_name')
                    ->label('Creator')
                    ->description(fn ($record) => $record->creator->last_name)
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('modifier.first_name')
                    ->label('Modifier')
                    ->description(fn ($record) => $record->modifier->last_name)
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('approver.first_name')
                    ->label('Approver')
                    ->description(fn ($record) => $record->approver->last_name)
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('approval_status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->icon(fn ($state) => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'approved' => 'heroicon-o-check-circle',
                        'rejected' => 'heroicon-o-x-circle',
                    }),
                TextColumn::make('published_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
                    ->label('Create Content')
                    ->url(fn (): string => ContentMgtResource::getUrl('create'))
                    ->icon('heroicon-m-document-text')
                    ->button(),
            ])
            ->emptyStateDescription('Belum ada konten terdaftar. Tambahkan konten aplikasi baru.')
            ->recordUrl(null);
    }
}
