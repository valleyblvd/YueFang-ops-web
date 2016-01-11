<?php
/**
 * http://stackoverflow.com/questions/30177156/laravel-4-hardcoded-authentication
 * http://laravel.io/forum/11-04-2014-laravel-5-how-do-i-create-a-custom-auth-in-laravel-5
 * https://gist.github.com/jcodt/f9ee49051b75df4d00bd
 */

namespace App\Providers;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;

class SimpleUserProvider implements UserProvider
{
    protected $user;

    public function __construct(array $credentials)
    {
        $this->user = new GenericUser(array_merge($credentials, array('id' => 1)));
    }

    public function retrieveById($identifier)
    {
        // TODO: Implement retrieveById() method.
        return $this->user;
    }

    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
    }

    public function updateRememberToken(UserContract $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->user;
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        return $credentials['email'] == $user->email && $credentials['password'] == $user->password;
    }


}