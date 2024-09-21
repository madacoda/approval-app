<?php

namespace App\Repositories;

use App\Models\Master\JobPosition;

class JobPositionRepository extends Repository
{
    public function __construct()
    {
        $this->model = new JobPosition();
    }
}
