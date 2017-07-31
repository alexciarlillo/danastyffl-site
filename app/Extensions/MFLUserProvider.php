<?php namespace App\Extensions;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class MFLUserProvider implements UserProvider {

    public function retrieveById($identifier)
	{

        $client = new Client([
            'base_uri' => "https://api.myfantasyleague.com/2017/"
        ]);

        $cookieJar = CookieJar::fromArray([
            'MFL_USER_ID' => $identifier
        ], '.myfantasyleague.com');

        $data = $client->get('export',
        [
            'query' => [
                'TYPE' => 'myleagues',
                'FRANCHISE_NAMES' => 1,
                'JSON'     => 1
            ],
            'cookies' => $cookieJar
        ]);

        $response = json_decode($data->getBody()->getContents());

        $leagues = $response->leagues->league;
        $league = null;

        if(is_array($leagues)) {
            $player_leagues = array_filter($leagues, function($l) {
                if( stristr($l->url, '30493') ) {
                    return true;
                } else {
                    return false;
                }
            });

            if(!empty($player_leagues))
                $league = $player_leagues[0];
        } else {
            if( stristr($leagues->url, '30493') ) {
                $league = $leagues;
            }
        }

        if($league) {
            return $league->franchise_name;
        }

        return null;
	}

	public function retrieveByToken($identifier, $token)
	{
        return new \Exception('not implemented');
	}

	public function updateRememberToken(UserContract $user, $token)
	{
        return new \Exception('not implemented');
	}

	public function retrieveByCredentials(array $credentials)
	{
        $client = new Client([
            'base_uri' => "https://api.myfantasyleague.com/2017/"
        ]);

        $data = $client->get('login', ['query' => [
            'USERNAME' => $credentials['username'],
            'PASSWORD' => $credentials['password'],
            'XML'     => 1
        ]]);

        $response = new \SimpleXMLElement($data->getBody());

        if( (string)$response[0] == "OK") {
                $name = $credentials['username'];
                $id = (string)$response['MFL_USER_ID'];
                return new MFLUser(['username' => $name, 'id' => $id]);
        }

        return null;
	}

	public function validateCredentials(UserContract $user, array $credentials)
	{
        return true;
	}

}
