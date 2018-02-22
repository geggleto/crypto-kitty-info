<?php


namespace Kitty\Http;


use function array_map;
use function implode;
use const JSON_PRETTY_PRINT;
use Kitty\Services\KittyService;
use function set_time_limit;
use Slim\Http\Request;
use Slim\Http\Response;

class ProfileController
{
    /**
     * @var KittyService
     */
    private $kittyService;

    public function __construct(KittyService $kittyService)
    {
        $this->kittyService = $kittyService;
    }

    public function __invoke($profile, Request $request, Response $response)
    {
        set_time_limit(0);
        $ids = KittyService::getAllKittiesOnProfile(strtolower($profile));

        $result = [];

        foreach ($ids as $id) {
            $result[$id] = $this->kittyService->getPrettyDnaKitten($id);
        }

        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    }

    public function exportToCsv($profile, Request $request, Response $response)
    {
        set_time_limit(0);

        $ids = KittyService::getAllKittiesOnProfile(strtolower($profile));

        return $this->kittyService->writeCsv($ids, $response);

    }
}