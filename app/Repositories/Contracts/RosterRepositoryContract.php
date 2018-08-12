<?php

namespace App\Repositories\Contracts;

interface RosterRepositoryContract
{
    public function fetch($id = null);
}
