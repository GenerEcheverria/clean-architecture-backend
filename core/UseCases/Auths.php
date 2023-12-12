<?php

namespace Core\UseCases;

use Core\Interfaces\IAuthStore;

class Auths
{
    private IAuthStore $iAuthStore;

    public function __construct(IAuthStore $iAuthStore)
    {
        $this->iAuthStore = $iAuthStore;
    }

    public function login(array $credentials)
    {
        return $this->iAuthStore->login($credentials);
    }

    public function refreshToken()
    {
        return $this->iAuthStore->refreshToken();
    }

    public function checkToken()
    {
        return $this->iAuthStore->checkToken();
    }

    public function logout()
    {
        $this->iAuthStore->logout();
    }
}
