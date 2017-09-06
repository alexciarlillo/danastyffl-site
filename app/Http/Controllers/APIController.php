<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Carbon\Carbon;

class APIController extends Controller
{
    public function league()
    {
        $cacheTime = Carbon::now()->addMinutes(10);

        $host = config('mfl.league_host');
        $year = config('mfl.league_year');

        $client = new Client([
            'base_uri' => "https://$host/$year/"
        ]);

        $data = $client->get('export', ['query' => [
            'L' => config('mfl.league_id'),
            'APIKEY' => config('mfl.api_key'),
            'JSON' => 1,
            'TYPE' => 'league'
        ]])->getBody()->getContents();

        return response($data)->header('Content-Type', 'application/json');
    }

    public function standings()
    {
        $host = config('mfl.league_host');

        $year = config('mfl.league_year');

        $client = new Client([
            'base_uri' => "https://$host/$year/"
        ]);

        $data = $client->get('export', ['query' => [
            'L' => config('mfl.league_id'),
            'APIKEY' => config('mfl.api_key'),
            'JSON' => 1,
            'TYPE' => 'leagueStandings'
        ]])->getBody()->getContents();

        return response($data)->header('Content-Type', 'application/json');
    }
}
