<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Interfaces\CacheStoreInterface;

class CacheService implements CacheStoreInterface
{
    public function getPublication(string $doi)
    {
        return Cache::get($this->getCacheKey($doi));
    }

    public function storePublication(string $doi, array $data)
    {
        Cache::put($this->getCacheKey($doi), $data, now()->addHours(4));
    }

    private function getCacheKey(string $doi)
    {
        return "publication_{$doi}";
    }
}
?>