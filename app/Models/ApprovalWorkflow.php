<?php

namespace App\Models;

use App\Models\Master\ApprovalConfigDetail;
use App\Models\Master\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalWorkflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'approval_config_detail_id',
        'module',
        'module_id',
        'comment',
        'sequence_number',
        'approver_module',
        'approver_module_id',
        'status',
    ];

    function approvalConfigDetail() {
        return $this->belongsTo(ApprovalConfigDetail::class, 'approval_config_detail_id');
    }

    function user() {
        return $this->belongsTo(User::class, 'approver_module_id', 'id');
    }

    function role() {
        return $this->belongsTo(Role::class, 'approver_module_id', 'id')->where('approver_module', 'role');
    }

    function approval() {
        return $this->belongsTo(Approval::class, 'module_id', 'id')->where('module', 'approval');
    }
}
