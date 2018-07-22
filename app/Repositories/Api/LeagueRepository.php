<?php

namespace App\Repositories\Api;

use JsonMapper;

use App\Services\MFLApiService;
use App\Repositories\Traits\UsesApi;
use App\League;
use App\Repositories\Contracts\ApiRepositoryContract;

use Illuminate\Support\Facades\Cache;
use App\Repositories\Contracts\LeagueRepositoryContract;

class LeagueRepository implements ApiRepositoryContract, LeagueRepositoryContract
{
    use UsesApi;

    protected $cacheKeyBase = 'league';

    public function __construct(MFLApiService $api)
    {
        $this->api = $api;
        $this->mapper = new JsonMapper();
    }

    public function fetch($year = null)
    {
        if ($year) {
            $cacheKey = "$this->cacheKeyBase.$year";
        } else {
            $cacheKey = $this->cacheKeyBase;
        }

        if (Cache::has($cacheKey)) {
            $league = Cache::get($cacheKey);
        } else {
            $leagueJSON = $this->api()->getLeague($year);
            $league = $this->mapper->map($leagueJSON, new League());
            Cache::put($cacheKey, $league, 60);
        }

        return $league;
    }
}
