<?php

namespace App\Extensions;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Contracts\Auth\Authenticatable;

class MFLUser implements Authenticatable {

    /**
     * All of the user's attributes.
     *
     * @var array
     */
    protected $attributes;
    /**
     * Create a new generic User object.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        // Return the name of unique identifier for the user (e.g. "id")
        return 'id';
    }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        $name = $this->getAuthIdentifierName();
        return $this->attributes[$name];
    }

    /**
     * @return string
     */
    public function getAuthPassword()
    {
        // Returns the (hashed) password for the user
        return new \Exception('not implemented');
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        // Return the token used for the "remember me" functionality
        return $this->attributes[$this->getRememberTokenName()];
    }

    /**
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // Store a new token user for the "remember me" functionality
        $this->attributes[$this->getRememberTokenName()] = $value;
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        // Return the name of the column / attribute used to store the "remember me" token
        return 'remember_token';
    }

    public function getTeamName() {

        $identifier = $this->getAuthIdentifier();

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
                if( stristr($l->url, config('mfl.league_id')) ) {
                    return true;
                } else {
                    return false;
                }
            });

            if(!empty($player_leagues))
                $league = $player_leagues[0];
        } else {
            if( stristr($leagues->url, config('mfl.league_id')) ) {
                $league = $leagues;
            }
        }

        if($league) {
            return $league->franchise_name;
        }

        return null;
    }
}
