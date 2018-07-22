<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Api\LeagueRepository;
use App\Repositories\Api\PlayerRepository;
use App\Repositories\Api\StandingsRepository;

class APIController extends Controller
{
    private $leagues;
    private $players;
    private $standings;

    public function __construct(
        LeagueRepository $leagues,
        PlayerRepository $players,
        StandingsRepository $standings
    )
    {
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
        $standings = $standings->all($year);

        return $standings->toJson();
    }

    public function scores($week = null)
    {
        $scores = null;
        $error = 'Unable to fetch MFL scores data.';

        if ($week) {
            $cacheKey = "mfl.scores.${week}";
        } else {
            $cacheKey = "mfl.scores.current";
        }

        if (Cache::has($cacheKey)) {
            $scores = Cache::get($cacheKey);
        } else {
            $response = $this->getScores($week);

            if ($response->getStatusCode() == 200) {
                $scores = $response->getBody()->getContents();
                Cache::put($cacheKey, $scores, 1);
            } else {
                $error = $response->getReasonPhrase();
            }
        }

        if ($scores) {
            return response()->json([
                'success' => true,
                'payload' => json_decode($scores)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => $error
            ]);
        }
    }



    private function getStandings()
    {
        return $this->client->get('export', ['query' =>
            [
                'L' => $this->leagueId,
                'APIKEY' => $this->apiKey,
                'JSON' => 1,
                'TYPE' => 'leagueStandings'
            ]
        ]);
    }

    private function getScores($week)
    {
        $query = [
            'L' => $this->leagueId,
            'APIKEY' => $this->apiKey,
            'JSON' => 1,
            'TYPE' => 'liveScoring',
            'DETAILS' => 1
        ];

        if ($week) {
            $query['W'] = $week;
        }

        return $this->client->get('export', ['query' => $query]);
    }
}
