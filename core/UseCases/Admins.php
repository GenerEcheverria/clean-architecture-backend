<?php

namespace Core\UseCases;

use Core\Interfaces\IAdminStore;

class Admins
{
    private $adminStore;

    public function __construct(IAdminStore $adminStore)
    {
        $this->adminStore = $adminStore;
    }

    public function getAll()
    {
        return $this->adminStore->getAll();
    }
}