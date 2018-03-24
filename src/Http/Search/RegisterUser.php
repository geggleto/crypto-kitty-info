<?php


namespace Kitty\Http\Search;


use const PASSWORD_BCRYPT;
use function password_hash;
use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class RegisterUser
{
    /**
     * @var PDO
     */
    private $pdo;

    private $statement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->statement = $pdo->prepare("insert into `kitty_users` (username, `password`) values(?,?)");
    }

    public function __invoke(Request $request, Response $response)
    {
        $this->statement->execute([$request->getParsedBodyParam('username'), password_hash($request->getParsedBodyParam('password'), PASSWORD_BCRYPT )]);

        return $response->withRedirect('/login');
    }
}