<?php

namespace App\Repositories\Api;

use JsonMapper;

use App\Services\MFLApiService;
use App\Repositories\Traits\UsesApi;
use App\Repositories\Contracts\ApiRepositoryContract;

use Illuminate\Support\Facades\Cache;
use App\Repositories\Contracts\RosterRepositoryContract;
use App\RostersFranchise;

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
        $rosters = Cache::remember($this->cacheKeyBase, 5, function () {
            $rostersJSON = $this->api->getRosters();
            $rosters = $this->mapper->mapArray($rostersJSON, [], RostersFranchise::class);

            return $rosters;
        });

        return collect($rosters);
    }

    public function franchise($id)
    {
        $cacheKey = "$this->cacheKeyBase.$id";

        $roster = Cache::remember($cacheKey, 5, function () use ($id) {
            $rosterJSON = $this->api->getRosters($id);
            $roster = $this->mapper->map($rosterJSON, new RostersFranchise());

            return $roster;
        });

        return $roster;
    }
}
