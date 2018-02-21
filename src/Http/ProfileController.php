<?php


namespace Kitty\Http;


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

        $result = [];

        foreach ($ids as $id) {
            $result[$id] = $this->kittyService->getPrettyDnaKitten($id);
        }

        $categories = [
            'mouth' => 4,
            'wild' => 5,
            'secondarycolor' => 6,
            'patterncolor' => 7,
            'bodycolor' => 8,
            'eyetype' => 9,
            'eyecolor' => 10,
            'pattern' => 11,
            'body' => 12
        ];

        $response = $response->write('kittyId,mouth,,,,wild,,,,seccolor,,,,patcolor,,,,bodycolor,,,,eyetype,,,,eyecolor,,,,pattern,,,,body,,,,'."\n");

        foreach ($categories as $categoryName => $categoryId)
        {
            foreach ($ids as $id) {
                $response = $response->write(implode(',', $result['id'])."\n");
            }
        }

        return $response;
    }
}