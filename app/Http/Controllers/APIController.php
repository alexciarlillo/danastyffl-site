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

        return json_encode($league);
    }

    public function players()
    {
        $players = $this->players->all();

        return $players->toJson();
    }

    public function standings($year = null)
    {
        $standings = $this->standings->all($year);

        return $standings->toJson();
    }

    public function scores($year = null)
    {
        $week = request()->input('week', null);

        $scores = $this->scores->all($year, $week);

        return $scores->toJson();
    }

    public function currentWeek()
    {
        $currentWeek = $this->scores->currentWeek();

        return $currentWeek;
    }
}
