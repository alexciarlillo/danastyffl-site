<?php

namespace App\Repositories\Api;

use JsonMapper;

use App\Services\MFLApiService;
use App\Repositories\Traits\UsesApi;
use App\Player;
use App\Repositories\Contracts\ApiRepositoryContract;

use Illuminate\Support\Facades\Cache;
use App\Repositories\Contracts\PlayerRepositoryContract;
use Illuminate\Support\Collection;

class PlayerRepository implements ApiRepositoryContract, PlayerRepositoryContract
{
    use UsesApi;

    public function __construct(MFLApiService $api)
    {
        $this->api = $api;
        $this->mapper = new JsonMapper();
    }

    public function all() : Collection
    {
        if (Cache::has('players')) {
            $players = Cache::get('players');
        } else {
            $playersJSON = $this->api()->getPlayers();
            $players = $this->mapper->mapArray($playersJSON, [], Player::class);
            Cache::put('players', $players, 1440); // one day
        }
        
        return collect($players);
    }

    public function find($ids) : Collection
    {
        $players = $this->all();

        return $players->whereIn('id', $ids);
    }
}
