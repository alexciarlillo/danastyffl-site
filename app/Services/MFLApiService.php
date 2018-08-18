<?php

namespace App\Services;

use App\Exceptions\MFLApiException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class MFLApiService
{
    public function __construct($leagueHost, $leagueId, $leagueApiKey)
    {
        $this->host = $leagueHost;
        $this->league = $leagueId;
        $this->key = $leagueApiKey;

        $this->client = new Client([
            'base_uri' => "https://$this->host/"
        ]);
    }

    private function export($params, $year = null)
    {
        if (!$year) {
            $year = now()->year;
        }

        $query = array_merge([
            'L' => $this->getLeagueId($year),
            'APIKEY' => $this->key,
            'JSON' => 1,
        ], $params);

        \Log::debug("Export Params: ", $params);

        $response = $this->client->get("$year/export", ['query' => $query]);

        if ($response->getStatusCode() !== 200) {
            throw new MFLApiException($query, $response->getStatusCode());
        }

        return json_decode($response->getBody()->getContents());
    }

    public function getLeague($year = null)
    {
        $params = [
            'TYPE' => 'league'
        ];

        $response = $this->export($params, $year);

        return $response->league;
    }

    public function getPlayers($ids = null)
    {
        $params = [
            'TYPE' => 'players',
            'DETAILS' => 1,
        ];

        if ($ids) {
            $params['PLAYERS'] = collect($ids)->implode(',');
        }

        $response = $this->export($params);

        return $response->players->player;
    }

    public function getStandings($year = null)
    {
        $params = [
            'TYPE' => 'leagueStandings'
        ];

        $response = $this->export($params, $year);

        return $response->leagueStandings->franchise;
    }

    public function getScores($year = null, $week = null)
    {
        $params = [
            'TYPE' => 'liveScoring',
            'DETAILS' => 1
        ];

        if ($week) {
            $params['W'] = $week;
        }

        $response = $this->export($params, $year);

        return $response->liveScoring->matchup;
    }

    public function getRosters($id = null)
    {
        $params = [
            'TYPE' => 'rosters'
        ];

        if ($id) {
            $params['FRANCHISE'] = str_pad($id, 4, "0", STR_PAD_LEFT);
        }

        $response = $this->export($params);

        return $response->rosters->franchise;
    }

    public function getCurrentWeek()
    {
        $params = [
            'TYPE' => 'liveScoring'
        ];

        $response = $this->export($params);

        return $response->liveScoring->week;
    }

    private function getLeagueId($year)
    {
        $map = Cache::remember('keys', 1440, function () {
            return $this->getLeagueIdsByYear();
        });

        if ($map->has($year)) {
            return $map->get($year);
        } else {
            throw new \Exception("No API key in map for $year");
        }
    }

    private function getLeagueIdsByYear()
    {
        $query = array_merge([
            'L' => $this->league,
            'APIKEY' => $this->key,
            'JSON' => 1,
            'TYPE' => 'league'
        ]);

        $year = now()->year;
        $response = $this->client->get("$year/export", ['query' => $query]);

        if ($response->getStatusCode() !== 200) {
            throw new MFLApiException($query, $response->getStatusCode());
        }

        $object = json_decode($response->getBody()->getContents());

        $years = collect($object->league->history->league);

        $map = $years->mapWithKeys(function ($year) {
            $arr = explode('/', $year->url);
            $id = end($arr);
            return [$year->year => $id];
        });

        return $map;
    }
}
