<?php


namespace Kitty\Http\BattleZone;


use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class Profile
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke($player_id, Request $request, Response $response)
    {
        $statement = $this->pdo->prepare('select * from kitty_usage where player_id = ? order by `timestamp` LIMIT 5');

        $statement->execute([ strtolower($player_id)]);

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $response->withJson($rows);
    }
}