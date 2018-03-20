<?php


namespace Kitty\Http\Search;


use Kitty\Search\KittySearch;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class SearchController
{
    /**
     * @var Twig
     */
    private $twig;
    /**
     * @var KittySearch
     */
    private $kittySearch;

    public function __construct(Twig $twig, KittySearch $kittySearch)
    {
        $this->twig = $twig;
        $this->kittySearch = $kittySearch;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $this->twig->render($response, "search/searchPage.html.twig", [
           $this->kittySearch->getMegaArray()
        ]);
    }
}