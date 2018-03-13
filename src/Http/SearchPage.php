<?php


namespace Kitty\Http;


use Kitty\Services\KittyService;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class SearchPage
{
    /**
     * @var Twig
     */
    private $twig;
    /**
     * @var KittyService
     */
    private $kittyService;

    public function __construct(Twig $twig, KittyService $kittyService)
    {
        $this->twig = $twig;
        $this->kittyService = $kittyService;
    }

    public function __invoke(Request $request, Response $response)
    {
        $categoriesRaw = $this->kittyService->getKai();
        $categories = [];

        foreach ($categoriesRaw as $x => $value)
        {
            $categories[$value['label']] = $value['codes'];
        }

        return $this->twig->render($response, 'searchPage.html.twig',
            ['categories' => json_encode($categories)]);
    }
}