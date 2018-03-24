<?php


namespace Kitty\Http\Search;


use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class SecurityMiddleware
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        if (isset($_SESSION['loggedIn'])) {
            return $next($request, $response);
        }

        return $response->withHeader('401','Unauthorized');
    }
}