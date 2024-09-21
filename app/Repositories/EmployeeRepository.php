<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Employee();
    }
}
