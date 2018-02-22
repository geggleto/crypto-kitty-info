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

        $result = [];

        //$response = $response->write('kittyId,mouth,,,,wild,,,,seccolor,,,,patcolor,,,,bodycolor,,,,eyetype,,,,eyecolor,,,,pattern,,,,body,,,,'."\n");
        $response = $response->write('kittyId,Gen,Fur,,,,Pattern,,,,Eye Color,,,,Eye Shape,,,,Base Color,,,,Highlight Color,,,,Accent Color,,,,Wild,,,,Mouth,,,,'."\n");

        foreach ($ids as $id) {

            $kitty = $this->kittyService->getKittyGen($id);

            $result[$id] = $this->kittyService->getPrettyDnaKitten($id);

            $response->write($id.','.$kitty['gen']);

            $dna = array_map(function ($dna) {
                return implode(',', $dna);
            }, $result[$id]);

            $response = $response->write(implode(',', $dna)."\n");
        }

        return $response
                ->withHeader('Content-Type', 'text/csv')
                ->withHeader('Content-Disposition', 'attachment; filename="profile.csv"');

    }
}