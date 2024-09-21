<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApprovalConfigRepository extends Repository
{
    public function __construct()
    {
        $this->model = new User();
    }
}
