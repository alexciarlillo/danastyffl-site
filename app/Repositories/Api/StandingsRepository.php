<?php

namespace App\Repositories\Api;

use JsonMapper;

use App\StandingsFranchise;
use App\Services\MFLApiService;
use App\Repositories\Traits\UsesApi;
use App\Repositories\Contracts\ApiRepositoryContract;
use App\Repositories\Contracts\StandingsRepositoryContract;

use Illuminate\Support\Facades\Cache;

class StandingsRepository implements ApiRepositoryContract, StandingsRepositoryContract
{
    use UsesApi;

    protected $cacheKeyBase = 'standings';

    public function __construct(MFLApiService $api)
    {
        $this->api = $api;
        $this->mapper = new JsonMapper();
    }

    public function all($year = null)
    {
        if ($year) {
            $cacheKey =  $this->cacheKeyBase . $year;
        } else {
            $cacheKey = $this->cacheKeyBase;
        }

        if (Cache::has($cacheKey)) {
            $standings = Cache::get($cacheKey);
        } else {
            $standingsJSON = $this->api()->getStandings($year);
            $standings = $this->mapper->mapArray($standingsJSON, [], StandingsFranchise::class);
            Cache::put($cacheKey, $standings, 1440); // one day
        }
        
        return collect($standings);
    }
}
