# Issue: Refactor MenuScheduleStatsWidget with Progress Bar and Doughnut Chart

## Context

Current `app/Filament/Widgets/MenuScheduleStatsWidget.php` uses standard `StatsOverviewWidget` which displays basic stat cards. We need to enhance the visualization with progress bars and add a doughnut chart for better data representation.

## Target

- **File to modify**: `app/Filament/Widgets/MenuScheduleStatsWidget.php`
- **New file to create**: `app/Filament/Widgets/MenuScheduleStatusChart.php`

## Requirements

### Status Values to Track

Based on `app/Models/MenuSchedule.php`, track these statuses:
- `approval_stage` (default status)
- `pending`
- `executed`
- `failed`
- `rejected`

### Task 1: Convert MenuScheduleStatsWidget to Progress Bar Format

**File**: `app/Filament/Widgets/MenuScheduleStatsWidget.php`

**Current behavior**: Displays 4-5 stat cards with basic numbers

**Required changes**:
1. Keep as `StatsOverviewWidget` but enhance with progress visualization
2. Calculate percentages for each status relative to total
3. Add progress bar visual representation using `chart()` method on Stat
4. Display 5 stats: Total, Approval Stage, Pending, Executed, Failed, Rejected

**Implementation guide**:
```php
// Calculate totals
$total = MenuSchedule::count();
$approvalStage = MenuSchedule::where('status', 'approval_stage')->count();
$pending = MenuSchedule::where('status', 'pending')->count();
$executed = MenuSchedule::where('status', 'executed')->count();
$failed = MenuSchedule::where('status', 'failed')->count();
$rejected = MenuSchedule::where('status', 'rejected')->count();

// For each stat, add chart data to create progress visualization
Stat::make('Approval Stage', $approvalStage)
    ->description($total > 0 ? round(($approvalStage / $total) * 100, 1) . '% of total' : '0%')
    ->descriptionIcon('heroicon-m-clock')
    ->chart([...]) // Add trending data or simple array to show as sparkline
    ->color('info')
```

**Expected result**: Widget shows stats with percentage descriptions and visual progress indicators

### Task 2: Create Doughnut Chart Widget

**File**: `app/Filament/Widgets/MenuScheduleStatusChart.php` (NEW)

**Requirements**:
1. Extend `Filament\Widgets\ChartWidget`
2. Use `'doughnut'` chart type
3. Query `MenuSchedule` and group by status
4. Show all 5 status categories with appropriate colors
5. Set `protected static ?int $sort = 3;` to position it properly
6. Set heading as `'Menu Schedule Status Distribution'`
7. Set `$columnSpan = 1` to control width

**Reference implementation pattern**: Follow `app/Filament/Widgets/UserStatusChart.php`

**Color scheme**:
- `approval_stage`: `#3b82f6` (blue-500) - info
- `pending`: `#f59e0b` (amber-500) - warning
- `executed`: `#10b981` (green-500) - success
- `failed`: `#ef4444` (red-500) - danger
- `rejected`: `#6b7280` (gray-500) - neutral

**Code structure**:
```php
<?php

namespace App\Filament\Widgets;

use App\Models\MenuSchedule;
use Filament\Widgets\ChartWidget;

class MenuScheduleStatusChart extends ChartWidget
{
    protected static ?int $sort = 3;
    
    protected ?string $heading = 'Menu Schedule Status Distribution';
    
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        // Query and group by status
        // Return datasets with labels and data
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
```

### Task 3: Register New Widget (if needed)

Check if widgets are auto-discovered or need manual registration. If using Filament panels, the widget should be auto-discovered.

## Verification Steps

Run these commands using sail:

```bash
# Clear cache
./vendor/bin/sail artisan optimize:clear

# Check for any syntax errors
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan view:clear

# Run linter
./vendor/bin/sail composer pint

# Optional: Run tests if widget tests exist
./vendor/bin/sail artisan test --filter=Widget
```

## Expected Outcome

1. **MenuScheduleStatsWidget**: Shows 6 stat cards (Total + 5 statuses) with:
   - Clear numbers
   - Percentage descriptions
   - Appropriate icons
   - Color coding (info, warning, success, danger, neutral)
   - Visual progress indicators

2. **MenuScheduleStatusChart**: Doughnut chart displaying:
   - 5 segments (one per status)
   - Color-coded segments matching stat colors
   - Labels showing status names
   - Smooth animations on load
   - Responsive layout

3. Both widgets visible on dashboard, properly sorted and positioned

## Notes

- This project uses Laravel Sail/Docker, always use `./vendor/bin/sail` prefix for commands
- Follow existing widget patterns in `app/Filament/Widgets/` directory
- Use Filament v4 conventions
- Ensure queries are optimized (avoid N+1)
- Status values must match database exactly (case-sensitive)
- Test with various data scenarios (empty, partial, full datasets)

## Files to Modify/Create

- [ ] Modify: `app/Filament/Widgets/MenuScheduleStatsWidget.php`
- [ ] Create: `app/Filament/Widgets/MenuScheduleStatusChart.php`
- [ ] Test: Verify both widgets render correctly on dashboard

## Definition of Done

- [ ] MenuScheduleStatsWidget displays all 5 status types plus total
- [ ] Each stat shows percentage and has appropriate color
- [ ] New doughnut chart widget created and displays correctly
- [ ] Chart uses correct colors matching the status semantics
- [ ] Code passes Laravel Pint formatting
- [ ] No console errors in browser
- [ ] Widgets are properly sorted on dashboard
- [ ] All status values are tracked accurately
