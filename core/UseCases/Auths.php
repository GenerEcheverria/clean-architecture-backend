<?php

namespace Core\UseCases;

//use Core\Entities\UserDTO;
use Core\Interfaces\IAuthStore;

use Illuminate\Support\Facades\Validator;

class Auths
{
    private $iAuthStore;

    public function __construct(IAuthStore $iAuthStore)
    {
        
        $this->iAuthStore = $iAuthStore;
    }
   
    public function login(array $credentials)
    {
        return $this->iAuthStore->login($credentials);
    }

    
}
