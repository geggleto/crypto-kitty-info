<?php


namespace Kitty\Http;


use function explode;
use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class GetCattributesForKitty
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke($id, Request $request, Response $response)
    {
        $statment = $this->pdo->prepare('select id, json_extract(kitty, \'$.enhanced_cattributes\') as `cattributes` from kitties where id IN (?);');
        $result = $statment->execute([$id]);

        if ($result) {
            return $response->withJson($statment->fetchAll(PDO::FETCH_ASSOC));
        } else {
            return $response->write("Error running sql statement");
        }
    }
}