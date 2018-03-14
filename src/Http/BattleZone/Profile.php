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
        $statement = $this->pdo->prepare("select *, CONCAT('https://storage.googleapis.com/ck-kitty-image/0x06012c8cf97bead5deae237070f9587f8e7a266d/',kitty_id , '.svg') as `image` from kitty_usage where player_id = ? order by `timestamp` LIMIT 5");

        $statement->execute([ strtolower($player_id)]);

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $out = ['battles' => $rows];


        $statsStatement = $this->pdo->prepare("select 
SUM(if (result = 0, 1, 0)) as losses,
SUM(if (result = 1, 1, 0)) as wins
from 
kitty_usage
where
player_id = ?");

        $statsStatement->execute([$player_id]);

        $stats = $statsStatement->fetch(PDO::FETCH_ASSOC);

        $out['wins'] = $stats['wins'];
        $out['losses'] = $stats['losses'];

        return $response->withJson($out);
    }
}