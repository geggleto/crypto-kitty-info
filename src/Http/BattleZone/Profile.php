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
        $statement = $this->pdo->prepare('select CONCAT(\'https://storage.googleapis.com/ck-kitty-image/0x06012c8cf97bead5deae237070f9587f8e7a266d/\',kittyId , \'.svg\') as `image` from kitty_usage where player_id = ? order by `timestamp` LIMIT 5');

        $statement->execute([ strtolower($player_id)]);

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $response->withJson($rows);
    }
}