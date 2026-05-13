<?php

namespace App\Console\Commands;

use App\Models\MenuSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessMenuSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-menu-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending menu activation and deactivation schedules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $schedules = MenuSchedule::with('menu')
            ->where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->get();

        if ($schedules->isEmpty()) {
            $this->info('No pending schedules to process.');

            return;
        }

        foreach ($schedules as $schedule) {
            try {
                DB::transaction(function () use ($schedule) {
                    $menu = $schedule->menu;

                    if ($menu) {
                        $isActive = $schedule->action_type === 'activate';
                        $menu->update(['is_active' => $isActive]);

                        $schedule->update([
                            'status' => 'executed',
                        ]);

                        $this->info("Successfully {$schedule->action_type}d menu: {$menu->menu_name}");
                    } else {
                        $schedule->update(['status' => 'failed']);
                        $this->error("Menu not found for schedule ID: {$schedule->id}");
                    }
                });
            } catch (\Exception $e) {
                $schedule->update(['status' => 'failed']);
                Log::error("Failed to process menu schedule ID {$schedule->id}: ".$e->getMessage());
                $this->error("Failed to process schedule ID: {$schedule->id}");
            }
        }
    }
}
