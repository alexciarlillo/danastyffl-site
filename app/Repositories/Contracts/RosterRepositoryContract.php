<?php

namespace App\Repositories\Contracts;

interface RosterRepositoryContract
{
    public function franchise($id);

    public function all();
}
