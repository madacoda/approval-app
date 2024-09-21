<?php

namespace App\Models;

use App\Models\Master\ApprovalCategory;
use App\Models\Master\JobPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_id',
        'approval_category_id',
        'user_id',
        'job_position_id',
        'new_job_position_id',
        'new_hb_distance',
        'effective_date',
        'note',
    ];

    function approval() {
        return $this->belongsTo(Approval::class);
    }

    function user() {
        return $this->belongsTo(User::class);
    }

    function jobPosition() {
        return $this->belongsTo(JobPosition::class);
    }

    function newJobPosition() {
        return $this->belongsTo(JobPosition::class, 'new_job_position_id');
    }

    function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    function category() {
        return $this->belongsTo(ApprovalCategory::class, 'approval_category_id');
    }
}
