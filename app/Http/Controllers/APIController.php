<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

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

    public function league()
    {
        $league = null;

        if (Cache::has('mfl.league')) {
            $league = Cache::get('mfl.league');
        } else {
            $response = $this->getLeague();

            if ($response->getStatusCode() == 200) {
                $league = $response->getBody()->getContents();
                Cache::put('mfl.league', $league, 60);
            }
        }

        if ($league) {
            return response()->json([
                'success' => true,
                'payload' => json_decode($league)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Unable to fetch MFL league data.'
            ]);
        }
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

    public function scores()
    {
        $scores = null;

        if (Cache::has('mfl.scores')) {
            $scores = Cache::get('mfl.scores');
        } else {
            $response = $this->getScores();

            if ($response->getStatusCode() == 200) {
                $scores = $response->getBody()->getContents();
                Cache::put('mfl.scores', $scores, 1);
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
                'error' => 'Unable to fetch MFL scores data.'
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

    private function getScores()
    {
        return $this->client->get('export', ['query' =>
            [
                'L' => $this->leagueId,
                'APIKEY' => $this->apiKey,
                'JSON' => 1,
                'TYPE' => 'liveScoring',
                'DETAILS' => 1
            ]
        ]);
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
