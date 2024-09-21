<?php

namespace App\Models;

use App\Models\Master\JobPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_position_id',
        'employee_number',
        'identity_number',
        'hb_distance',
        'unit',
        'area',
        'branch',
        'regional'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }
}
