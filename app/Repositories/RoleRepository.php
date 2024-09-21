<?php

namespace App\Repositories;

use App\Models\Master\Role;

class RoleRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Role();
    }
}
