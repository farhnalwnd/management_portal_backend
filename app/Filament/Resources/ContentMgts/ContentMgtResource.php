<?php

namespace App\Filament\Resources\ContentMgts;

use App\Filament\Resources\ContentMgts\Pages\CreateContentMgt;
use App\Filament\Resources\ContentMgts\Pages\EditContentMgt;
use App\Filament\Resources\ContentMgts\Pages\ListContentMgts;
use App\Filament\Resources\ContentMgts\Pages\ViewContentMgt;
use App\Filament\Resources\ContentMgts\Schemas\ContentMgtForm;
use App\Filament\Resources\ContentMgts\Schemas\ContentMgtInfolist;
use App\Filament\Resources\ContentMgts\Tables\ContentMgtsTable;
use App\Models\ContentMgt;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentMgtResource extends Resource
{
    protected static ?string $model = ContentMgt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ContentMgtForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
            Section::make('Informasi Utama')
                ->description('Detail informasi modul dan publikasi.')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('title')
                                ->label('Judul')
                                ->weight('bold')
                                ->columnSpan(1),
                            TextEntry::make('type')
                                ->label('Tipe')
                                ->badge()
                                ->color('primary'),
                            TextEntry::make('module.module_name')
                                ->label('Module')
                                ->copyable(),
                            TextEntry::make('version')
                                ->label('Versi')
                                ->badge()
                                ->color('success'),
                        ]),

                    TextEntry::make('repo')
                        ->label('Repository URL')
                        ->url(fn($record) => $record->repo)
                        ->openUrlInNewTab()
                        ->color('info')
                        ->icon('heroicon-m-link'),

                    TextEntry::make('published_date')
                        ->label('Tanggal Publish')
                        ->dateTime('d M Y'),
                ])->columnSpan(1),

            Section::make('Status & Penanggung Jawab')
                ->schema([
                    Grid::make(3)
                        ->schema([
                            TextEntry::make('approval_status')
                                ->badge()
                                ->color(fn(string $state): string => match ($state) {
                                    'approved' => 'success',
                                    'pending' => 'primary',
                                    'rejected' => 'warning',
                                    default => 'gray',
                                }),
                            TextEntry::make('approver.first_name')
                                ->state(fn($record) => $record->approver ? $record->approver->first_name . ' ' . $record->approver->last_name : '-')
                                ->label('Approver Name'),
                            TextEntry::make('published_date')
                                ->label('Action Date')
                                ->dateTime('d M Y'),
                        ]),
                ])->columnSpan(1)->collapsible(),

            Section::make('Audit Trail')
                ->description('Informasi riwayat perubahan data.')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('creator.first_name')
                                ->state(fn($record) => $record->creator ? $record->creator->first_name . ' ' . $record->creator->last_name : '-')
                                ->label('Dibuat Oleh'),
                            TextEntry::make('modifier.first_name')
                                ->state(fn($record) => $record->modifier ? $record->modifier->first_name . ' ' . $record->modifier->last_name : '-')
                                ->label('Terakhir Diubah Oleh'),
                            TextEntry::make('created_at')
                                ->label('Waktu Dibuat')
                                ->dateTime(),
                            TextEntry::make('updated_at')
                                ->label('Waktu Update')
                                ->dateTime(),
                        ]),
                ])->compact()->collapsible()->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return ContentMgtsTable::configure($table);
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
            'index' => ListContentMgts::route('/'),
            'create' => CreateContentMgt::route('/create'),
            // 'view' => ViewContentMgt::route('/{record}'),
            'edit' => EditContentMgt::route('/{record}/edit'),
        ];
    }
}
