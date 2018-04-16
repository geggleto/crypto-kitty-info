<?php


namespace Kitty\Search;


use Kitty\Services\KittyService;
use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class MewtationSearch
{
    /**
     * @var KittyService
     */
    private $kittyService;

    public function __construct(KittyService $kittyService)
    {
        $this->kittyService = $kittyService;
    }

    public function __invoke(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $out = $this->kittyService->getMewtations($body['cattribute']);

        return $response->withJson($out);
    }
}