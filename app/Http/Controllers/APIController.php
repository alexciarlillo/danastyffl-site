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
        $league = Cache::remember('league', 60, function () {
            return $this->getLeague();
        });
        return response($league)->json([
            'success' => true,
            'payload' => json_decode($league)
        ]);
    }

    public function standings()
    {
        $standings = Cache::remember('standings', 60, function () {
            return $this->getStandings();
        });

        return response()->json([
            'success' => true,
            'payload' => json_decode($standings)
        ]);
    }

    public function scores()
    {
        $scores = Cache::remember('scores', 1, function () {
            return $this->getScores();
        });

        return response()->json({
            'success' => true,
            'payload' => json_decode($scores)
        });
    }

    public function players()
    {
        $players = Cache::remember('players', 3600, function () {
            return $this->getPlayers();
        });

        return response()->json({
            'success' => true,
            'payload' => json_decode($players)
        });
    }

    private function getLeague()
    {
        return $this->client->get('export', ['query' => [
            'L' => $this->leagueId,
            'APIKEY' => $this->apiKey,
            'JSON' => 1,
            'TYPE' => 'league'
        ]])->getBody()->getContents();
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
        ])->getBody()->getContents();
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
        ])->getBody()->getContents();
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
        ])->getBody()->getContents();
    }
}
