<?php


namespace Kitty\Http;


use function array_reverse;
use function implode;
use InvalidArgumentException;
use const JSON_PRETTY_PRINT;
use Kitty\Services\KittyService;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use function strlen;
use function strpos;
use function var_dump;

class SearchDnaController
{
    /**
     * @var KittyService
     */
    private $kittyService;
    /**
     * @var Twig
     */
    private $twig;

    public function __construct(KittyService $kittyService, Twig $twig)
    {
        $this->kittyService = $kittyService;
        $this->twig = $twig;
    }

    public function __invoke(Request $request, Response $response)
    {
        $params = $request->getQueryParams();

        $kitties = $this->kittyService->findKittiesFromArray($params);

        $onsale = isset($params['onsale']);

        $price = isset($params['price'])?$params:false;

        $kittyArray = $this->kittyService->getKittyTable($kitties, $onsale, $price);

        $categories = [
            'mouth',
            'wild',
            'secondarycolor',
            'patterncolor',
            'bodycolor',
            'eyetype',
            'eyecolor',
            'pattern',
            'body'
        ];

        $categories = array_reverse($categories);

        return $this->twig->render($response, 'search2.html.twig', [
            'kitties' => json_encode($kittyArray, JSON_PRETTY_PRINT),
            'categories' => $categories
        ]);
    }
}