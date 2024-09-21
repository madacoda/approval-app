<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends Repository
{
    public function __construct()
    {
        $this->model = new User();
    }
}
