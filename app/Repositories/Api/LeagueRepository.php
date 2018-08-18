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

        $league = Cache::remember($cacheKey, 60, function () {
            $leagueJSON = $this->api()->getLeague($year);
            return $this->mapper->map($leagueJSON, new League());
        });

        return $league;
    }
}
