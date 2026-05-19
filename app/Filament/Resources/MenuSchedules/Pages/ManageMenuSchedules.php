<?php

namespace App\Filament\Resources\MenuSchedules\Pages;

use App\Filament\Resources\MenuSchedules\MenuScheduleResource;
use App\Models\MenuSchedule;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ManageMenuSchedules extends ManageRecords
{
    protected static string $resource = MenuScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth('xl'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->badge(static fn (): int => MenuSchedule::query()->count('status')),
            'approval_stage' => Tab::make('Approval Stage')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approval_stage'))
                ->badge(static fn (): int => MenuSchedule::query()->where('status', 'approval_stage')->count()),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))
                ->badge(static fn (): int => MenuSchedule::query()->where('status', 'pending')->count()),
            'executed' => Tab::make('Executed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'executed'))
                ->badge(static fn (): int => MenuSchedule::query()->where('status', 'executed')->count()),
            'failed' => Tab::make('Failed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'failed'))
                ->badge(static fn (): int => MenuSchedule::query()->where('status', 'failed')->count()),
            'rejected' => Tab::make('Rejected')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected'))
                ->badge(static fn (): int => MenuSchedule::query()->where('status', 'rejected')->count()),
        ];
    }
}
