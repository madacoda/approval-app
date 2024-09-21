<?php

namespace App\Repositories;

use App\Models\Master\Subdistrict;

class SubdistrictRepository extends Repository
{
    public function __construct()
    {
        $this->model = new Subdistrict();
    }
}
