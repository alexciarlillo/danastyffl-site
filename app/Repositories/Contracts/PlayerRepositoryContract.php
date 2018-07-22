<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface PlayerRepositoryContract
{
    public function all() : Collection;

    /**
     * @param int|array $ids
     * @return Collection|Player
     */
    public function find($ids) : Collection;
}
