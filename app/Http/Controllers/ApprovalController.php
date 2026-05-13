<?php

namespace App\Http\Controllers;

use App\Models\ApprovalMgt;
use App\Models\ContentMgt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApprovalController extends Controller
{
    public function approval(int $id, string $token, string $status)
    {
        try {
            return DB::transaction(function () use ($id, $token, $status) {
                $approvalMgt = ApprovalMgt::where('content_id', $id)
                    ->where('token', $token)
                    ->where('approval_status', 'pending')
                    ->lockForUpdate()
                    ->first();

                if (! $approvalMgt) {
                    Log::error('Approval Process: tidak ditemukan atau sudah diproses: '.$id.' '.$token);

                    throw new \Exception('Link sudah tidak valid atau sudah pernah diproses.');
                }

                $approvalMgt->approval_status = $status;
                $approvalMgt->token = null;
                $approvalMgt->save();

                $contentMgt = ContentMgt::findOrFail($id);
                $contentMgt->approval_status = $status;
                $contentMgt->last_modified_by = $approvalMgt->approver_id;

                if ($status == 'approved') {
                    $contentMgt->status = true;
                }
                $contentMgt->save();

                return view('mail.approval-success');
            });
        } catch (\Throwable $e) {
            Log::error('Approval Process Error: '.$e->getMessage(), [
                'exception' => $e,
                'id' => $id,
                'token' => $token,
                'status' => $status,
            ]);

            return view('mail.approval-failed', ['e' => $e]);
        }
    }
}
