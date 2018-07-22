<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Api\LeagueRepository;

class APIController extends Controller
{
    public function __construct()
    {
        $this->host = config('mfl.league_host');
        $this->year = config('mfl.league_year');
        $this->leagueId = config('mfl.league_id');
        $this->apiKey = config('mfl.api_key');

        $this->client = new Client([
            'base_uri' => "https://$this->host/$this->year/"
        ]);
    }

    public function league(LeagueRepository $leagues)
    {
        $league = $leagues->fetch();

        return json_encode($league);
    }

    public function standings()
    {
        $standings = null;

        if (Cache::has('mfl.standings')) {
            $standings = Cache::get('mfl.standings');
        } else {
            $response = $this->getStandings();

            if ($response->getStatusCode() == 200) {
                $standings = $response->getBody()->getContents();
                Cache::put('mfl.standings', $standings, 60);
            }
        }

        if ($standings) {
            return response()->json([
                'success' => true,
                'payload' => json_decode($standings)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Unable to fetch MFL standings data.'
            ]);
        }
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

    public function players()
    {
        $players = null;

        if (Cache::has('mfl.players')) {
            $players = Cache::get('mfl.players');
        } else {
            $response = $this->getPlayers();

            if ($response->getStatusCode() == 200) {
                $players = $response->getBody()->getContents();
                Cache::put('mfl.players', $players, 1);
            }
        }

        if ($players) {
            return response()->json([
                'success' => true,
                'payload' => json_decode($players)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Unable to fetch MFL players data.'
            ]);
        }
    }

    private function getLeague()
    {
        return $this->client->get('export', ['query' => [
            'L' => $this->leagueId,
            'APIKEY' => $this->apiKey,
            'JSON' => 1,
            'TYPE' => 'league'
        ]]);
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

    private function getPlayers()
    {
        return $this->client->get('export', ['query' =>
            [
                'L' => $this->leagueId,
                'APIKEY' => $this->apiKey,
                'JSON' => 1,
                'TYPE' => 'players'
            ]
        ]);
    }
}
