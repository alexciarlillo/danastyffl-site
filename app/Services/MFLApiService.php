<?php

namespace App\Services;

use App\Exceptions\MFLApiException;
use GuzzleHttp\Client;

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
            'L' => $this->league,
            'APIKEY' => $this->key,
            'JSON' => 1,
        ], $params);

        $response = $this->client->get("$year/export", ['query' => $query]);

        if ($response->getStatusCode() !== 200) {
            throw new MFLApiException($query, $response->getStatusCode());
        }

        return $response;
    }

    public function getLeague($year = null)
    {
        $params = [
            'TYPE' => 'league'
        ];

        $response = $this->export($params, $year);
        $object = json_decode($response->getBody()->getContents());

        return $object->league;
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
        $object = json_decode($response->getBody()->getContents());

        return $object->players->player;
    }

    public function getStandings($year = null)
    {
        $params = [
            'TYPE' => 'leagueStandings'
        ];

        $response = $this->export($params, $year);
        $object = json_decode($response->getBody()->getContents());

        return $object->leagueStandings->franchise;
    }
}
