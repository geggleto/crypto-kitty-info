<?php


namespace Kitty\Http;


use function array_reverse;
use function implode;
use InvalidArgumentException;
use const JSON_PRETTY_PRINT;
use Kitty\Security\AuthService;
use Kitty\Services\KittyService;
use PDO;
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
     * @var AuthService
     */
    private $authService;

    /**
     * SearchDnaController constructor.
     *
     * @param KittyService $kittyService
     * @param AuthService  $authService
     */
    public function __construct(KittyService $kittyService, AuthService $authService)
    {
        $this->kittyService = $kittyService;
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $response;
//
//        $params = $request->getQueryParams();
//
//        $kitties = $this->kittyService->findKittiesFromArray($params);
//
//        $onsale = isset($params['onsale']);
//
//        $price = isset($params['price'])?$params:false;
//
//        $kittyArray = $this->kittyService->getKittyTable($kitties, $onsale, $price);
//
//        $categories = [
//            'mouth',
//            'wild',
//            'secondarycolor',
//            'patterncolor',
//            'bodycolor',
//            'eyetype',
//            'eyecolor',
//            'pattern',
//            'body'
//        ];
//
//        $categories = array_reverse($categories);
//
//        return $this->twig->render($response, 'search2.html.twig', [
//            'kitties' => json_encode($kittyArray, JSON_PRETTY_PRINT),
//            'categories' => $categories
//        ]);
    }

    public function query($profile, Request $request, Response $response)
    {
        if (!$this->authService->authorize($profile)) {
            return $response->withStatus(401);
        }

        $body = $request->getParsedBody();

        $count = $this->kittyService->getCountKittiesFromArray($body);

        $kitties = $this->kittyService->findKittiesFromArray($body);

        $result = [
            'count' => $count['count'],
            'results' => []
        ];

        $onsale = false;

        if (isset($body['onsale']) && $body['onsale'] === 'true')
        {
            $onsale = true;
        }

        foreach ($kitties as $kitty) {

            $forSale = '';

            $forSale = KittyService::getSaleInfo($kitty['id']);

            if (($onsale && $forSale) || !$onsale) {

                $cat         = $this->kittyService->getPrettyDnaKitten($kitty['id']);
                $cat['sale'] = $forSale;

                $result['results'][$kitty['id']] = $cat;
            }

        }

        return $response->withJson($result, 200, JSON_PRETTY_PRINT);
    }
}