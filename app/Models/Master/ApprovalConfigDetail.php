<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalConfigDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_config_id',
        'sequence_number',
        'module',
        'module_id',
        'created_by',
        'updated_by',
    ];

    public function approvalConfig()
    {
        return $this->belongsTo(ApprovalConfig::class, 'approval_config_id');
    }

    function role() {
        return $this->belongsTo(Role::class, 'module_id')->where('module', 'role');
    }

    function user() {
        return $this->belongsTo(User::class, 'module_id')->where('module', 'user');
    }
}
