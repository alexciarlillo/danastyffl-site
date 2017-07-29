<?php

namespace App;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AuthenticatesUser {
    use ValidatesRequests;

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function authorize() {
        $this->validateRequest()
             ->doLogin()
             ->createToken();
    }

    protected function validateRequest() {
        $this->validate($this->request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        return $this;
    }

    protected function doLogin() {
        $client = new Client([
            'base_uri' => "https://api.myfantasyleague.com/2017/"
        ]);

        $data = $client->get('login', ['query' => [
            'USERNAME' => $this->request->input('username'),
            'PASSWORD' => $this->request->input('password'),
            'XML'     => 1
        ]]);

        $response = new \SimpleXMLElement($data->getBody());
        dd((string)$response[0]);
        //response($data)->header('Content-Type', 'application/json');
        return $this;
    }

    protected function createToken() {

        // Store the cookie value in the session

        return $this;
    }
}
