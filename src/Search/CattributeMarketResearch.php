<?php


namespace Kitty\Search;


use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class CattributeMarketResearch
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * CattributeMarketResearch constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke(Request $request, Response $response)
    {
        $result = $this->pdo->query('select generation, cattribute, price from `kitty_attribute_prices` where `date` = date(NOW())');

        return $response->withJson($result->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findCattributePrices($cattribute, Request $request, Response $response)
    {
        $statement = $this->pdo->prepare('select `date`, generation, price from `kitty_attribute_prices` where cattribute = ?');
        $statement->execute([$cattribute]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $response->withJson($result);
    }
}