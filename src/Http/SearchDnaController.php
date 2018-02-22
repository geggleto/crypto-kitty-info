<?php


namespace Kitty\Http;


use function array_reverse;
use function implode;
use InvalidArgumentException;
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

        $kittyArray = $this->kittyService->getKittyTable($kitties, $onsale);

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

        return $this->twig->render($response, 'search.html.twig', [
            'kitties' => $kittyArray,
            'categories' => $categories
        ]);
    }

}