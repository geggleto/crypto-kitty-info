<?php


namespace Kitty\Security;


use Slim\Http\Request;
use Slim\Http\Response;

class Authorization
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke(Request $request, Response $response)
    {
        $profile = $request->getParsedBodyParam('profile');

        $statement = $this->pdo->prepare('select * from authorizations where playerId = ?');

        $statement->execute([$profile]);

        return $response->withJson([
            'isAuthorized' => ($statement->rowCount())
        ]);

    }
}