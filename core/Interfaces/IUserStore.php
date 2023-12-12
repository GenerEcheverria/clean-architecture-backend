<?php

namespace Core\Interfaces;

use Core\Entities\UserDTO;

interface IUserStore
{
    public function save(UserDTO $client): void;

    public function getAll();

    public function getById(int $id);

    public function isUserStored(int $id): bool;

    public function update(UserDTO $client, $id);

    public function delete(int $id): bool;

    public function getUserData();
}
