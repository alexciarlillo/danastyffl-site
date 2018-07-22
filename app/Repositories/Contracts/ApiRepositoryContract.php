<?php

namespace App\Repositories\Contracts;

use App\Services\MFLApiService;

interface ApiRepositoryContract
{
    public function api() : MFLApiService;
}
