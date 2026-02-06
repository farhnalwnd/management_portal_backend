<?php

namespace App\Http\Controllers;

use App\Models\ApprovalMgt;
use App\Models\ContentMgt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApprovalController extends Controller
{
    public function approval($id, $token, $status)
    {
        try {
            DB::beginTransaction();
            $approvalMgt = ApprovalMgt::where('content_id', $id)->where('token', $token)->where('approval_status', 'pending')->first();

            if (!$approvalMgt) {
                return view('mail.approval-failed', [
                    'e' => new \Exception("Link sudah tidak valid atau sudah pernah diproses.")
                ]);
            }

            $approvalMgt->approval_status = $status;
            $approvalMgt->token = null;
            $approvalMgt->save();

            $contentMgt = ContentMgt::findOrFail($id);
            $contentMgt->approval_status = $status;
            $contentMgt->last_modified_by = $approvalMgt->approver_id;
            if ($status == 'approved') {
                $contentMgt->status = 'active';
            }
            $contentMgt->save();

            DB::commit();
            return view('mail.approval-success');
        } catch (\Exception $e) {
            DB::rollBack();
            return view('mail.approval-failed', compact('e'));
        }
    }
}
