<?php

namespace App\Filament\Resources\ApprovalMasters\Tables;

use App\Filament\Resources\ApprovalMasters\ApprovalMasterResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApprovalMastersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('approver.first_name')
                    ->description(fn ($record) => $record->approver->last_name)
                    ->label('Approver Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('level')
                    ->numeric()
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Create Approval Config')
                    ->url(fn (): string => ApprovalMasterResource::getUrl('create'))
                    ->icon('heroicon-m-clipboard-document-check')
                    ->button(),
            ])
            ->emptyStateDescription('Belum ada konfigurasi approval. Tambahkan konfigurasi approval baru.');
    }
}
