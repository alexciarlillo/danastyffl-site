<?php

namespace App\Repositories\Contracts;

interface LeagueRepositoryContract
{
    public function fetch($year = null);
}
