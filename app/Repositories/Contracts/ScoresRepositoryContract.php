<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface ScoresRepositoryContract
{
    public function all($year = null, $week = null) : Collection;
}
