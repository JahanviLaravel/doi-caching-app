<?php
namespace App\Services;

use App\Interfaces\CacheStoreInterface;
use App\Interfaces\APISourceInterface;

class PublicationService
{
    protected $cacheService;
    protected $apiService;

    public function __construct(CacheStoreInterface $cacheService, APISourceInterface $apiService)
    {
        $this->cacheService = $cacheService;
        $this->apiService = $apiService;
    }
    
    //* Get publication by DOI from local cache or API.     
    public function getPublicationByDOI(string $doi)
    {
        // Check if the publication exists in the local cache
        $doi = urlencode($doi);
        $cachedPublication = $this->cacheService->getPublication($doi);

        if ($cachedPublication) {
            return $cachedPublication;
        }

        // If not in cache, fetch from CrossRef
        $apiData = $this->apiService->getPublication($doi);

        if ($apiData) {
            // Store the fetched data in the cache
            $this->cacheService->storePublication($doi, $apiData);
        }

        return $apiData;
    }
}