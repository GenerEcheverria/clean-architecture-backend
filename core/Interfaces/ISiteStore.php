<?php
namespace Core\Interfaces;

interface ISiteStore
{
    public function getAll();
    public function isSiteStored(int $id): bool;
    public function updateState(int $id, string $state);
    public function save($site, $user);
}