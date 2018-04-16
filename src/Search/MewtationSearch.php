<?php


namespace Kitty\Search;


use Kitty\Services\KittyService;
use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class MewtationSearch
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $statement = $this->pdo->prepare('select
kitty_jewel_id as `id`,
`position`
from
kitty_mewtations
where 
description LIKE ?
and kitty_id = kitty_jewel_id
order by position asc LIMIT 100;');

        $statement->execute([$body['cattribute']]);

        $kitties = $statement->fetchAll();

        $out = [];

        foreach ($kitties as $kitty) {
            $out[] = [
                'id' => $kitty['id'],
                'position' => $kitty['position'],
                'price' => KittyService::getSaleInfo($kitty['id'])
            ];
        }

        return $response->withJson($out);
    }
}