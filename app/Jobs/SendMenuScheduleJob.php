<?php

namespace App\Jobs;

use App\Mail\SendMenuScheduleMail;
use App\Models\ApprovalMgt;
use App\Models\MenuSchedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMenuScheduleJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;

    public $backoff = 5;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public MenuSchedule $menuSchedule,
        public ApprovalMgt $approvalMgt,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $approveLink = route('approval.menu_schedule', [
            'id' => $this->menuSchedule->id,
            'token' => $this->approvalMgt->token,
            'status' => 'approved',
        ]);

        $rejectLink = route('approval.menu_schedule', [
            'id' => $this->menuSchedule->id,
            'token' => $this->approvalMgt->token,
            'status' => 'rejected',
        ]);

        Mail::to($this->approvalMgt->approver->email)
            ->send(new SendMenuScheduleMail($this->menuSchedule, $this->approvalMgt, $approveLink, $rejectLink));

        Log::info('data dari $this->approvalMgt adalah: '.$this->approvalMgt);
    }
}
