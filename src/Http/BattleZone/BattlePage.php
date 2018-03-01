<?php


namespace Kitty\Http\BattleZone;


use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class BattlePage
{
    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Request $request, Response $response)
    {
        return $this->twig->render($response, 'battlezone/liveBattle.html.twig');
    }
}