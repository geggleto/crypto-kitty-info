<?php


namespace Kitty\Http;


use Kitty\Services\KittyService;
use Slim\Http\Request;
use Slim\Http\Response;
use function strlen;

class DnaController
{
    /**
     * @var KittyService
     */
    private $kittyService;

    public function __construct(KittyService $kittyService)
    {
        $this->kittyService = $kittyService;
    }

    public function searchBody($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findBody($code));
    }
}