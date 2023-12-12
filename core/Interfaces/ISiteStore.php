<?php

namespace Core\Interfaces;

interface ISiteStore
{
    public function getAll();

    public function isSiteStored(int $id): bool;

    public function updateState(int $id, string $state);

    public function save($site, $user);

    public function getSitesForCurrentUser($user);

    public function getSitesByUser($userId);

    public function getState(string $url);

    public function getSite(int $id);
}
