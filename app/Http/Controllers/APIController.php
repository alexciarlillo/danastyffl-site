<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class APIController extends Controller
{
    public function league() {
        $cacheTime = Carbon::now()->addMinutes(10);

        $host = Cache::remember('mfl_league_host', $cacheTime, function() {
            return config('mfl.league_host');
        });

        $year = Cache::remember('mfl_league_year', $cacheTime, function() {
            return config('mfl.league_year');
        });


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

    public function standings() {
        $cacheTime = Carbon::now()->addMinutes(10);

        $host = Cache::remember('mfl_league_host', $cacheTime, function() {
            return config('mfl.league_host');
        });

        $year = Cache::remember('mfl_league_year', $cacheTime, function() {
            return config('mfl.league_year');
        });


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

    public function login(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        dd($username);
    }
}
