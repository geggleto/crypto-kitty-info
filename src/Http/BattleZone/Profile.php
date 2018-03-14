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
        $statement = $this->pdo->prepare("select 
ku.*, 
CONCAT('https://storage.googleapis.com/ck-kitty-image/0x06012c8cf97bead5deae237070f9587f8e7a266d/',kitty_id , '.svg') as `image`, 
(select ku2.kitty_id from kitty_usage ku2 where ku.battle_id = ku2.battle_id AND ku.kitty_id != ku2.kitty_id)  as `kitty2`

from kitty_usage ku

where ku.player_id = ? order by ku.`timestamp` LIMIT 5;");


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