<?php

namespace App\Repositories;

use App\Models\Approval;
use App\Models\ApprovalWorkflow;
use App\Models\Master\ApprovalConfig;

class ApprovalWorkflowRepository extends Repository
{
    public function __construct()
    {
        $this->model = new ApprovalWorkflow();
    }

    function generate($module, $module_id, array $additional_approvers = []) {
        $approval_config = ApprovalConfig::where('module', $module)->first();
        $approval_config_details = $approval_config->details;

        $approval_workflow_inputs = [];
        foreach($approval_config_details as $key => $approval_config_detail) {
            // For now i only setup logic for approver module user
            if($approval_config_detail->module == 'user') {
                $approval_workflow_inputs[] = [
                    'approval_config_detail_id' => $approval_config_detail->id,
                    'module'                    => $module,
                    'module_id'                 => $module_id,
                    'sequence_number'           => $approval_config_detail->sequence_number,
                    'approver_module'           => 'user',
                    'approver_module_id'        => $approval_config_detail->module_id,
                    'status'                    => 'progress',
                    'created_at'                => now(),
                ];
            }
        }

        if(count($additional_approvers) > 1) {
            $approval_workflow_inputs[] = [
                'approval_config_detail_id' => null,
                'module'                    => $module,
                'module_id'                 => $module_id,
                'sequence_number'           => $additional_approvers['sequence_number'],
                'approver_module'           => 'user',
                'approver_module_id'        => $additional_approvers['user_id'],
                'status'                    => 'progress',
                'created_at'                => now(),
            ];
        }

        $workflows = ApprovalWorkflow::insert($approval_workflow_inputs);

        return $workflows;
    }
}
