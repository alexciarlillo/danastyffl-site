<?php namespace App\Extensions;

use GuzzleHttp\Client;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class MFLUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return new MFLUser(['id' => $identifier]);
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

        if ((string)$response[0] == "OK") {
            $name = $credentials['username'];
            $id = (string)$response['MFL_USER_ID'];
            return new MFLUser(['id' => $id]);
        }

        return null;
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        return true;
    }
}
