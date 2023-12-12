<?php

namespace Core\Entities;

class UserDTO
{
    public $name;

    public $email;

    public $password;

    public $role;

    public $phone;

    public function __construct($name, $email, $password, $role, $phone)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->phone = $phone;
    }
}
