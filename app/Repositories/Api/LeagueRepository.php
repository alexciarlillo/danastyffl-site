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
        $league = Cache::remember('league', 60, function() {
            $leagueJSON = $this->api()->getLeague();
            return $this->mapper->map($leagueJSON, new League());
        });
    }

}
