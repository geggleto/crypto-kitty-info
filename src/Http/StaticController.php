<?php


namespace Kitty\Http;


use Kitty\Search\KittySearch;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class StaticController
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

    public function showLogin(Request $request, Response $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->twig->render($response, 'login.html.twig');
    }

    public function showRegister(Request $request, Response $response): \Psr\Http\Message\ResponseInterface
    {
        return $this->twig->render($response, 'register.html.twig');
    }

    public function showProfilePage(Request $request, Response $response)
    {
        return $this->twig->render($response, 'profile.html.twig');
    }

    public function showIndexPage(Request $request, Response $response)
    {
        return $this->twig->render($response, 'index.html.twig');
    }

    public function showKittySearch(Request $request, Response $response)
    {
        return $this->twig->render($response, "search/searchPage.html.twig", [
            'data' => json_encode($this->kittySearch->getMegaArray(), JSON_PRETTY_PRINT)
        ]);
    }
}