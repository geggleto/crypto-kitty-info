<?php


namespace Kitty\Http;


use function implode;
use InvalidArgumentException;
use Kitty\Services\KittyService;
use Slim\Http\Request;
use Slim\Http\Response;
use function strlen;
use function strpos;

class SearchDnaController
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
        $params = $request->getQueryParams();

        $kitties = $this->kittyService->findKittiesFromArray($params);

        return $this->kittyService->writeCsvWithSales($kitties, $response);
    }

}