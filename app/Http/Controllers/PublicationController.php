<?php
namespace App\Http\Controllers;

use App\Services\PublicationService;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    protected $publicationService;

    public function __construct(PublicationService $publicationService)
    {
        $this->publicationService = $publicationService;
    }

    /**
     * Get publication by DOI.
     *
     * @param string $doi
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPublication($doi)
    {
        try {
            $publication = $this->publicationService->getPublicationByDOI($doi);

            if ($publication) {
                return response()->json(['data' => $publication], 200,[], JSON_PRETTY_PRINT);
            } else {
                return response()->json(['error' => 'Publication not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
}
