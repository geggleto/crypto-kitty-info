<?php


namespace Kitty\Http;


use Slim\Http\Request;
use Slim\Http\Response;
use function var_dump;

class KittySaleEvent
{
    /**
     * @var \PDO
     */
    private $PDO;

    /**
     * KittySaleEvent constructor.
     *
     * @param \PDO $PDO
     */
    public function __construct(\PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    public function bulkImport(Request $request, Response $response)
    {
        $query = $this->PDO->prepare('insert into `kitty_sales` VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $items = $request->getParsedBody();



        foreach ($items['items'] as $body) {

            if (count($body) !== 8) {
                return $response->withStatus(400);
            }

            $query->execute([
                $body['tx'],
                $body['blockNumber'],
                $body['event'],
                $body['tokenId'],
                $body['startingPrice'],
                $body['endingPrice'],
                $body['duration'],
                $body['address'] ?? "",
            ]);
        }

        return $response->withJson($body);
    }

    public function __invoke(Request $request, Response $response)
    {
        $query = $this->PDO->prepare('insert into `kitty_sales` VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $body = $request->getParsedBody();

        if (count($body) !== 8) {
            return $response->withStatus(400);
        }

        $query->execute([
            $body['tx'],
            $body['blockNumber'],
            $body['event'],
            $body['tokenId'],
            $body['startingPrice'],
            $body['endingPrice'],
            $body['duration'],
            $body['address'] ?? "",
        ]);

        return $response->withJson($body);
    }

    public function getLastBlock(Request $request, Response $response)
    {
        $statement = $this->PDO->query('select max(blockNumber) as `blockNumber` from `kitty_sales`');
        $statement->execute();
        $result = $statement->fetch();
        return $response->withJson($result);
    }
}