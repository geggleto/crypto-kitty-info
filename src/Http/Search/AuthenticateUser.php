<?php


namespace Kitty\Http\Search;


use function password_verify;
use PDO;
use PDOStatement;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthenticateUser
{
    /**
     * @var PDO
     */
    private $pdo;

    /** @var PDOStatement */
    private $statement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->statement = $pdo->prepare("select `username`, `password` from `kitty_users` where `username` = ? and `disabled` = '0'");
    }

    public function __invoke(Request $request, Response $response)
    {
        $result = $this->statement->execute([$request->getParsedBodyParam('username')]);

        if ($result) {
            $row = $this->statement->fetch(PDO::FETCH_ASSOC);

            if (password_verify($request->getParsedBodyParam('password'), $row['password'])) {
                $_SESSION['loggedIn'] = true;

                return $response->withRedirect('/v2/search');
            }
        }

        return $response->withStatus(401, 'Unauthorized');
    }
}