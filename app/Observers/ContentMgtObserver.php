<?php

namespace App\Observers;

use App\Jobs\sendApprovalJob;
use App\Models\ApprovalMgt;
use App\Models\ContentMgt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContentMgtObserver
{
    /**
     * Handle the ContentMgt "created" event.
     */
    public function created(ContentMgt $contentMgt): void
    {
        $token = Str::random(16);

        $approvalmgt = ApprovalMgt::create([
            'content_id' => $contentMgt->id,
            'approver_id' => $contentMgt->approver_id,
            'token' => $token,
            'approval_status' => 'pending',
            'approval_level' => 1,
        ]);

        sendApprovalJob::dispatch($contentMgt, $approvalmgt);

        Log::info('data dari $contentMgt adalah: '.$contentMgt);
        Log::info('ApprovalMgt created for content '.$contentMgt->id);
    }

    /**
     * Handle the ContentMgt "updated" event.
     */
    public function updated(ContentMgt $contentMgt): void
    {
        //
    }

    /**
     * Handle the ContentMgt "deleted" event.
     */
    public function deleted(ContentMgt $contentMgt): void
    {
        //
    }

    /**
     * Handle the ContentMgt "restored" event.
     */
    public function restored(ContentMgt $contentMgt): void
    {
        //
    }

    /**
     * Handle the ContentMgt "force deleted" event.
     */
    public function forceDeleted(ContentMgt $contentMgt): void
    {
        //
    }
}
