<?php

namespace Core\UseCases;

use Core\Entities\UserDTO;
use Core\Interfaces\AdminStore;

class Admins
{
    private $adminStore;

    public function __construct(AdminStore $adminStore)
    {
        $this->adminStore = $adminStore;
    }

    public function getAll()
    {
        return $this->adminStore->getAll();
    }
}