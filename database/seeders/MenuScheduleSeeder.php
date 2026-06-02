<?php

namespace Database\Seeders;

use App\Models\ApprovalMaster;
use App\Models\MenuMgt;
use App\Models\MenuSchedule;
use Illuminate\Database\Seeder;

class MenuScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $approver = ApprovalMaster::where('level', 1)->first();
        $menus = MenuMgt::take(4)->get();

        if ($approver && $menus->count() >= 4) {
            $schedules = [
                [
                    'menu_id' => $menus[0]->id,
                    'approver_id' => $approver->id,
                    'action_type' => 'activate',
                    'scheduled_at' => now()->addDays(1),
                    'status' => 'pending',
                ],
                [
                    'menu_id' => $menus[1]->id,
                    'approver_id' => $approver->id,
                    'action_type' => 'deactivate',
                    'scheduled_at' => now()->subDays(1),
                    'status' => 'executed',
                ],
                [
                    'menu_id' => $menus[2]->id,
                    'approver_id' => $approver->id,
                    'action_type' => 'activate',
                    'scheduled_at' => now()->subDays(2),
                    'status' => 'failed',
                ],
                [
                    'menu_id' => $menus[3]->id,
                    'approver_id' => $approver->id,
                    'action_type' => 'deactivate',
                    'scheduled_at' => now()->addDays(2),
                    'status' => 'approval_stage',
                ],
            ];

            foreach ($schedules as $schedule) {
                MenuSchedule::create($schedule);
            }
        }
    }
}
