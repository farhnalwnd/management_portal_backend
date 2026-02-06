<?php

namespace App\Jobs;

use App\Mail\sendApprovalMail;
use App\Models\ApprovalMgt;
use App\Models\ContentMgt;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class sendApprovalJob implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $backoff = 5;

    protected $contentMgt;
    protected $approvalMgt;

    /**
     * Create a new job instance.
     */
    public function __construct(ContentMgt $contentMgt, ApprovalMgt $approvalMgt)
    {
        $this->contentMgt = $contentMgt;
        $this->approvalMgt = $approvalMgt;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $approveLink = route('approval.content', [
            'id' => $this->contentMgt->id,
            'token' => $this->approvalMgt->token,
            'status' => 'approved',
        ]);

        $rejectLink = route('approval.content', [
            'id' => $this->contentMgt->id,
            'token' => $this->approvalMgt->token,
            'status' => 'rejected',
        ]);

        Mail::to($this->contentMgt->approver->email)->send(new sendApprovalMail($this->contentMgt, $this->approvalMgt, $approveLink, $rejectLink));
    }
}
