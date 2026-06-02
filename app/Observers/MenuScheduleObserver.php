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
            try {
                \Illuminate\Support\Facades\DB::transaction(function () use ($menuSchedule) {
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

                        Log::info('MenuSchedule created with approval', [
                            'menu_schedule_id' => $menuSchedule->id,
                            'approval_mgt_id' => $approvalmgt->id,
                        ]);

                        SendMenuScheduleJob::dispatch($menuSchedule, $approvalmgt);
                    } else {
                        Log::warning('No approval master found for level 1', [
                            'menu_schedule_id' => $menuSchedule->id,
                        ]);
                    }
                });
            } catch (\Throwable $e) {
                Log::error('MenuScheduleObserver error', [
                    'exception' => $e->getMessage(),
                    'menu_schedule_id' => $menuSchedule->id,
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
    }
}
