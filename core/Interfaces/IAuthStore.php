<?php
namespace Core\Interfaces;

interface IAuthStore
{
    public function login(array $credentials);

}