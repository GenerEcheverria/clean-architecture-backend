<?php
namespace Core\Interfaces;

use Core\Entities\ClientDTO;

interface ClientStore
{
    public function save(ClientDTO $client): void;
}
