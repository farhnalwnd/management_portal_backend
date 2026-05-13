<?php

namespace App\Observers;

use App\Jobs\SendMenuScheduleJob;
use App\Models\ApprovalMgt;
use App\Models\MenuSchedule;
use Illuminate\Support\Str;

class MenuScheduleObserver
{
    /**
     * Handle the MenuSchedule "created" event.
     */
    public function created(MenuSchedule $menuSchedule): void
    {
        $approvalMaster = \App\Models\ApprovalMaster::where('level', 1)->first();

        if ($approvalMaster) {
            $token = Str::random(16);

            $approvalmgt = ApprovalMgt::create([
                'approver_id' => $approvalMaster->approver_id,
                'menu_schedule_id' => $menuSchedule->id,
                'token' => $token,
                'approval_status' => 'pending',
                'approval_level' => 1,
            ]);

            SendMenuScheduleJob::dispatch($menuSchedule, $approvalmgt);
        }
    }

    /**
     * Handle the MenuSchedule "updated" event.
     */
    public function updated(MenuSchedule $menuSchedule): void
    {
        //
    }

    /**
     * Handle the MenuSchedule "deleted" event.
     */
    public function deleted(MenuSchedule $menuSchedule): void
    {
        //
    }

    /**
     * Handle the MenuSchedule "restored" event.
     */
    public function restored(MenuSchedule $menuSchedule): void
    {
        //
    }

    /**
     * Handle the MenuSchedule "force deleted" event.
     */
    public function forceDeleted(MenuSchedule $menuSchedule): void
    {
        //
    }
}
