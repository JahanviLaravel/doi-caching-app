<?php

namespace App\Interfaces;

interface CacheStoreInterface
{
    public function getPublication(string $doi);

    public function storePublication(string $doi, array $data);
}