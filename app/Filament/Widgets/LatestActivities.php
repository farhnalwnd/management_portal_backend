<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

class LatestActivities extends TableWidget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Latest Audit Activities';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Activity::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('log_name')
                    ->badge(),
                TextColumn::make('description'),
                TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn (string $state): string => str_replace('App\\Models\\', '', $state)),
                TextColumn::make('causer.name')
                    ->label('User')
                    ->placeholder('System'),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->paginated(false);
    }
}
