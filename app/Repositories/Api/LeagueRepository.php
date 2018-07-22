<?php

namespace App\Repositories\Api;

use JsonMapper;

use App\Services\MFLApiService;
use App\Repositories\Traits\UsesApi;
use App\League;
use App\Repositories\Contracts\ApiRepositoryContract;

use Illuminate\Support\Facades\Cache;

class LeagueRepository implements ApiRepositoryContract
{
    use UsesApi;

    public function __construct(MFLApiService $api)
    {
        $this->api = $api;
        $this->mapper = new JsonMapper();
    }

    public function fetch()
    {
        if (Cache::has('league')) {
            $league = Cache::get('league');
        } else {
            $leagueJSON = $this->api()->getLeague();
            $league = $this->mapper->map($leagueJSON, new League());
            Cache::put('league', $league, 60);
        }
        
        return $league;
    }
}
