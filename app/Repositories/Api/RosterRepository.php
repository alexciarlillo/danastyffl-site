<?php

namespace App\Repositories\Api;

use JsonMapper;

use App\Services\MFLApiService;
use App\Repositories\Traits\UsesApi;
use App\Roster;
use App\Repositories\Contracts\ApiRepositoryContract;

use Illuminate\Support\Facades\Cache;
use App\Repositories\Contracts\RosterRepositoryContract;

class RosterRepository implements ApiRepositoryContract, RosterRepositoryContract
{
    use UsesApi;

    protected $cacheKeyBase = 'rosters';

    public function __construct(MFLApiService $api)
    {
        $this->api = $api;
        $this->mapper = new JsonMapper();
    }

    public function all()
    {
        $rosters = Cache::remember($this->cacheKeyBase, 5, function () use ($id) {
            $rostersJSON = $this->api->getRosters();
            $roster = $this->mapper->mapArray($rostersJSON, [], Roster::class);

            return $roster;
        });

        return collect($rosters);
    }

    public function franchise($id)
    {
        $cacheKey = "$this->cacheKeyBase.$id";

        Cache::remember($cacheKey, 5, function () use ($id) {
            $rosterJSON = $this->api->getRosters($id);
            $roster = $this->mapper->map($rosterJSON, Roster::class);

            return $roster;
        });

        return $roster;
    }
}
