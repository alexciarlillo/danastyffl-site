<?php

namespace App\Extensions;

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
}
