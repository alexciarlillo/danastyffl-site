<?php namespace App\Extensions;

use Illuminate\Auth\UserProviderInterface;
use Illuminate\Contracts\Auth\User as UserContract;

class MFLUserProvider implements UserProviderInterface {

    public function retrieveById($identifier)
	{

	}

	public function retrieveByToken($identifier, $token)
	{

	}

	public function updateRememberToken(UserContract $user, $token)
	{

	}

	public function retrieveByCredentials(array $credentials)
	{

	}

	public function validateCredentials(UserContract $user, array $credentials)
	{

	}

}
