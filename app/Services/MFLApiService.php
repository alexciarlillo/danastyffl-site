<?php

namespace App\Services;

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

        return $this->client->get("$year/export", ['query' => $query]);
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
}
