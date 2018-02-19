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

    public function searchPattern($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findPattern($code));
    }

    public function searchEyeColor($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findEyeColor($code));
    }

    public function searchEyeType($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findEyeType($code));
    }

    public function searchBodyColor($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findBodyColor($code));
    }

    public function searchPatternColor($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findPatternColour($code));
    }

    public function searchSecondaryColour($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findSecondaryColour($code));
    }

    public function searchWild($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findWild($code));
    }

    public function searchMouth($code, Request $request, Response $response) {
        if (strlen($code) !== 4) {
            return $response->withStatus(400);
        }

        return $response->withJson($this->kittyService->findMouth($code));
    }
}