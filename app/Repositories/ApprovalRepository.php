<?php

namespace App\Repositories;

use App\Models\Approval;
use App\Models\ApprovalDetail;
use App\Models\ApprovalWorkflow;
use Illuminate\Support\Facades\DB;

class ApprovalRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Approval();
    }

    function paginate($limit = 10) {
        if(auth()->user()->role_id == 1) {
            return $this->model->with('category')->latest()->paginate($limit);
        }

        return $this->model->whereHas('approvalWorkflows', function($query) {
            $query->where('approver_module', 'user')->where('approver_module_id', auth()->user()->id)
            ->where('status', 'progress');
        })->paginate($limit);
    }

    function destroy(int $id) {
        DB::beginTransaction();
        ApprovalWorkflow::where('module', 'approval')->where('module_id', $id)->delete();
        ApprovalDetail::where('approval_id', $id)->delete();
        Approval::where('id', $id)->delete();
        DB::commit();
    }
}
