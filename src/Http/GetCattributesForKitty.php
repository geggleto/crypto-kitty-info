<?php


namespace Kitty\Http;


use function explode;
use const JSON_PRETTY_PRINT;
use PDO;
use Slim\Http\Request;
use Slim\Http\Response;
use function stripslashes;
use function var_dump;

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
        $tokens = explode(',', $id);

        $tokenPlaceHolder = [];

        for($x=0; $x<count($tokens); $x++) {
            $tokenPlaceHolder[] = '?';
        }

        $statment = $this->pdo->prepare('select id, json_extract(kitty, \'$.enhanced_cattributes\') as `cattributes` from kitties where id IN ('.implode(',', $tokenPlaceHolder).');');
        $result = $statment->execute($tokens);

        $all = $statment->fetchAll(PDO::FETCH_ASSOC);

        $out = [];


        foreach ($all as $item) {
            $out[$item['id']] = json_decode($item['cattributes'], true);
        }

        if ($result) {
            return $response->withJson($out, 200,  JSON_PRETTY_PRINT);
        }

        return $response->write("Error running sql statement");
    }
}