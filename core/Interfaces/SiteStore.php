<?php
namespace Core\Interfaces;
interface SiteStore
{
    public function getAll();
    public function isSiteStored(int $id): bool;
    public function updateState(int $id, string $state);
}