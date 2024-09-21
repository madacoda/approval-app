<?php

namespace App\Models\Master;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'module',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function approval()
    {
        return $this->belongsTo(Approval::class, 'module_id')->where('module', 'approval');
    }

    public function details()
    {
        return $this->hasMany(ApprovalConfigDetail::class, 'approval_config_id');
    }
}
