<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Interfaces\APISourceInterface;


class CrossRefAPIService implements APISourceInterface{
    private $httpClient;

    public function __construct(Client $httpClient) {
        $this->httpClient = $httpClient;
    }

    // Get publication data by DOI from CrossRef.    
    public function getPublication(string $doi): ?array {
        // Validate the DOI format
        if (!$this->isValidDoi($doi)) {
            Log::error("Invalid DOI format: $doi");

            // Return a JSON response indicating that the DOI is invalid
            return ['error' => 'Invalid DOI format'];
        }

        $url = "https://api.crossref.org/works/{$doi}";
        try {
            $response = $this->httpClient->get($url);

            // Check if the request was successful (status code 200)
            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody(), true); 
                return $data;
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            Log::error("Error fetching publication data from CrossRef for DOI {$doi}: {$errorMessage}");
        }

        return null;
    }
    //function to validate the Cross Ref DOI
    private function isValidDoi(string $doi): bool {
        // Define the regular expression pattern for a DOI
        $doiPattern = '/^10\.\d{4,}\/\S+$/i';

        // Use preg_match to check if the DOI matches the pattern
        return preg_match($doiPattern, urldecode($doi)) === 1;
    }

}
?>