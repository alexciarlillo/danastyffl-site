<?php

namespace App\Repositories\Api;

use JsonMapper;

use App\StandingsFranchise;
use App\Services\MFLApiService;
use App\Repositories\Traits\UsesApi;
use App\Repositories\Contracts\ApiRepositoryContract;
use App\Repositories\Contracts\StandingsRepositoryContract;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

class StandingsRepository implements ApiRepositoryContract, StandingsRepositoryContract
{
    use UsesApi;

    protected $cacheKeyBase = 'standings';

    public function __construct(MFLApiService $api)
    {
        $this->api = $api;
        $this->mapper = new JsonMapper();
    }

    public function all($year = null) : Collection
    {
        if ($year) {
            $cacheKey =  "$this->cacheKeyBase.$year";
        } else {
            $cacheKey = $this->cacheKeyBase;
        }

        $standings = Cache::remember($cacheKey, 1440, function () use ($year) {
            $standingsJSON = $this->api()->getStandings($year);
            return $this->mapper->mapArray($standingsJSON, [], StandingsFranchise::class);
        });
        
        return collect($standings);
    }
}
