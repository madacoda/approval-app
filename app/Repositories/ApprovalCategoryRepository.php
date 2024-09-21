<?php

namespace App\Repositories;

use App\Models\Master\ApprovalCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApprovalCategoryRepository extends Repository
{
    public function __construct()
    {
        $this->model = new ApprovalCategory();
    }
}
