<?php


namespace Kitty\Http;


use function explode;
use PDO;
use Slim\Http\Request;
use Slim\Http\Response;
use function stripslashes;

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

        $all = $statment->fetchAll(PDO::FETCH_ASSOC);

        $out = [];

        foreach ($all as $item) {
            $out[] = [
                'id' => $item['id'],
                'cattributes' => stripslashes($item['cattributes'])
            ];
        }

        if ($result) {
            return $response->withJson($out);
        }

        return $response->write("Error running sql statement");

    }
}