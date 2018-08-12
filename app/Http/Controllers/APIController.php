<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Repositories\Api\LeagueRepository;
use App\Repositories\Api\PlayerRepository;
use App\Repositories\Api\ScoresRepository;
use App\Repositories\Api\StandingsRepository;

class APIController extends Controller
{
    private $leagues;
    private $players;
    private $standings;
    private $scores;

    public function __construct(
        LeagueRepository $leagues,
        PlayerRepository $players,
        StandingsRepository $standings,
        ScoresRepository $scores
    ) {
        $this->host = config('mfl.league_host');
        $this->year = config('mfl.league_year');
        $this->leagueId = config('mfl.league_id');
        $this->apiKey = config('mfl.api_key');

        $this->client = new Client([
            'base_uri' => "https://$this->host/$this->year/"
        ]);

        $this->leagues = $leagues;
        $this->players = $players;
        $this->standings = $standings;
        $this->scores = $scores;
    }

    public function league()
    {
        $league = $this->leagues->fetch();

        return response()->json($league);
    }

    public function players()
    {
        $players = $this->players->all();

        return response()->json($players);
    }

    public function standings($year = null)
    {
        $standings = $this->standings->all($year);

        return response()->json($standings);
    }

    public function scores($year = null)
    {
        $week = request()->input('week', null);

        $scores = $this->scores->all($year, $week);

        return response()->json($scores);
    }

    public function rosters($id = null)
    {
        if ($id) {
            return response()->json($this->rosters->franchise($id));
        } else {
            return response()->json($this->rosters->all());
        }
    }

    public function currentWeek()
    {
        $currentWeek = $this->scores->currentWeek();

        return response()->json($currentWeek);
    }
}
