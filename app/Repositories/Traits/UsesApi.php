<?php

namespace App\Repositories\Traits;

use App\Services\MFLApiService;


trait UsesApi
{
    public function api() : MFLApiService
    {
        return $this->api;
    }
}
