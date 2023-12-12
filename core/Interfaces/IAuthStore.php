<?php

namespace Core\Interfaces;

interface IAuthStore
{
    public function login(array $credentials);

    public function refreshToken();

    public function checkToken();

    public function logout();
}
