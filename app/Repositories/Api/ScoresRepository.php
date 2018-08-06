<?php

namespace App\Repositories\Api;

use JsonMapper;

use App\Services\MFLApiService;
use App\Repositories\Traits\UsesApi;
use App\Repositories\Contracts\ApiRepositoryContract;
use App\Repositories\Contracts\ScoresRepositoryContract;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use App\Matchup;

class ScoresRepository implements ApiRepositoryContract, ScoresRepositoryContract
{
    use UsesApi;

    protected $cacheKeyBase = 'scores';

    public function __construct(MFLApiService $api)
    {
        $this->api = $api;
        $this->mapper = new JsonMapper();
    }

    public function all($year = null, $week = null) : Collection
    {
        if ($year) {
            $cacheKey =  "$this->cacheKeyBase.$year";
        } else {
            $cacheKey = $this->cacheKeyBase;
        }

        if ($week) {
            $cacheKey = "$cacheKey.$week";
        }

        $scores = Cache::remember($cacheKey, 2, function () use ($year, $week) {
            $scoresJSON = $this->api()->getScores($year, $week);
            $scores = $this->mapper->mapArray($scoresJSON, [], Matchup::class);
            return $scores;
        });
        
        return collect($scores);
    }

    public function currentWeek()
    {
        return Cache::remember('current-week', 60, function () {
            return $this->api()->getCurrentWeek();
        });
    }
}
