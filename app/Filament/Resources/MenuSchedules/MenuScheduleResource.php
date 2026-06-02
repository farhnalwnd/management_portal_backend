<?php

namespace App\Filament\Resources\MenuSchedules;

use App\Filament\Resources\MenuSchedules\Pages\ManageMenuSchedules;
use App\Models\ApprovalMaster;
use App\Models\MenuSchedule;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class MenuScheduleResource extends Resource
{
    protected static ?string $model = MenuSchedule::class;

    protected static ?string $modelLabel = 'Menu Schedule';

    protected static ?string $pluralModelLabel = 'Menu Schedules';

    protected static string|UnitEnum|null $navigationGroup = 'Feature Support';

    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('menu_id')
                    ->label('Pilih Menu')
                    ->relationship('menu', 'menu_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpan(1),

                DateTimePicker::make('scheduled_at')
                    ->label('Waktu Eksekusi')
                    ->placeholder('DD/MM/YYYY - HH:mm')
                    ->seconds(false)
                    ->native(false)
                    ->minDate(now())
                    ->required()
                    ->columnSpan(1),

                Radio::make('action_type')
                    ->label('Action')
                    ->columns(2)
                    ->options([
                        'activate' => 'Activate Menu',
                        'deactivate' => 'Deactivate Menu',
                    ])
                    ->descriptions([
                        'activate' => 'Akan mengaktifkan menu pada waktu yang ditentukan',
                        'deactivate' => 'Akan menonaktifkan menu pada waktu yang ditentukan',
                    ])
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('approver_id')
                    ->label('Approver ID')
                    ->disabled()
                    ->dehydrated()
                    ->default(function () {
                        $approvalMaster = ApprovalMaster::query()->where('level', 1)->first();

                        return $approvalMaster ? $approvalMaster->id : null;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['menu', 'approvalMaster']))
            ->columns([
                TextColumn::make('menu.menu_name')
                    ->label('Menu Name')
                    ->sortable(),
                TextColumn::make('action_type')
                    ->label('Action')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'activate' => 'success',
                        'deactivate' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('scheduled_at')
                    ->label('Scheduled At')
                    ->isoDateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'executed' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalWidth('xl'),
                EditAction::make()
                    ->modalWidth('xl'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateDescription('Belum ada list Menu Schedule untuk saat ini. Silakan tambahkan buat baru.');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMenuSchedules::route('/'),
        ];
    }
}
