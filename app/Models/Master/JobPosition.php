<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->exists) {
                $model->updated_by = auth()->user()->id ?? null;
            } else {
                $model->created_by = auth()->user()->id ?? null;
            }
        });
    }

    function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
