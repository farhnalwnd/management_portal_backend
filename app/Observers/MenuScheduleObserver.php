<?php

namespace App\Observers;

use App\Jobs\SendMenuScheduleJob;
use App\Models\ApprovalMaster;
use App\Models\ApprovalMgt;
use App\Models\MenuSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MenuScheduleObserver
{
    /**
     * Handle the MenuSchedule "created" event.
     */
    public function created(MenuSchedule $menuSchedule): void
    {
        if ($menuSchedule->status === 'approval_stage') {
            $approvalMaster = ApprovalMaster::where('level', 1)->first();

            if ($approvalMaster) {
                $token = Str::random(16);

                $approvalmgt = ApprovalMgt::create([
                    'approver_id' => $approvalMaster->approver_id,
                    'menu_schedule_id' => $menuSchedule->id,
                    'token' => $token,
                    'approval_status' => 'pending',
                    'approval_level' => 1,
                ]);

                Log::info('data dari $menuSchedule adalah: '.$menuSchedule);

                SendMenuScheduleJob::dispatch($menuSchedule, $approvalmgt);
            }
        }
    }
}
