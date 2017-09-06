<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

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
        $data = $this->client->get('export', ['query' => [
            'L' => $this->leagueId,
            'APIKEY' => $this->apiKey,
            'JSON' => 1,
            'TYPE' => 'league'
        ]])->getBody()->getContents();

        return response($data)->header('Content-Type', 'application/json');
    }

    public function standings()
    {
        $data = $this->client->get('export', ['query' =>
            [
                'L' => $this->leagueId,
                'APIKEY' => $this->apiKey,
                'JSON' => 1,
                'TYPE' => 'leagueStandings'
            ]
        ])->getBody()->getContents();

        return response($data)->header('Content-Type', 'application/json');
    }

    public function scores()
    {
        $data = $this->client->get('export', ['query' =>
            [
                'L' => $this->leagueId,
                'APIKEY' => $this->apiKey,
                'JSON' => 1,
                'TYPE' => 'liveScoring'
            ]
        ])->getBody()->getContents();

        return response($data)->header('Content-Type', 'application/json');
    }
}
