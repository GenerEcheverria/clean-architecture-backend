<?php

namespace Core\UseCases;

//use Core\Entities\UserDTO;
use Core\Interfaces\IAuthStore;

use Illuminate\Support\Facades\Validator;

class Auths
{
    private $authStore;

    public function __construct(AuthStore $authStore)
    {
        $this->authStore = $authStore;
    }
   
    public function login(array $credentials)
    {
        $this->$authStore->login($credentials);
    }

    
}
