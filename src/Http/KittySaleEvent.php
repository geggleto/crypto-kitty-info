<?php


namespace Kitty\Http;


use Slim\Http\Request;
use Slim\Http\Response;

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

    public function __invoke(Request $request, Response $response)
    {
        $query = $this->PDO->prepare('insert into `kitty_sales` VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        $body = $request->getParsedBody();

        $query->execute([
            $body['tx'],
            $body['blockNumber'],
            $body['event'],
            $body['tokenId'],
            $body['startingPrice'],
            $body['endingPrice'],
            $body['duration'],
            $body['address'],
        ]);

        return $response;
    }
}