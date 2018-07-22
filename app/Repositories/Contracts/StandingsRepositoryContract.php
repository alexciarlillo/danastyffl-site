<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface StandingsRepositoryContract
{
    public function all() : Collection;
}
