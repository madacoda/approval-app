<?php

namespace App\Models;

use App\Models\Master\ApprovalCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_category_id',
        'memo_number',
        'unit',
        'area',
        'consideration',
        'status',
        'created_by',
        'updated_by',        
    ];

    function category() {
        return $this->belongsTo(ApprovalCategory::class, 'approval_category_id');
    }

    function details() {
        return $this->hasMany(ApprovalDetail::class);
    }

    function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    function approvalWorkflows() {
        return $this->hasMany(ApprovalWorkflow::class, 'module_id');
    }
}
