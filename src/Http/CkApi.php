<?php


namespace Kitty\Http;


use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class CkApi
{
    /**
     * @var PDO
     */
    private $PDO;

    /**
     * CkApi constructor.
     *
     * @param PDO $PDO
     */
    public function __construct(PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    public function __invoke(Request $request, Response $response)
    {
        $statement = $this->PDO->query('select
count(*) as `api_issue`
from kitties
where gen = -1 AND id > ( (select max(id) from kitties) - 1000 )');

        $results = $statement->fetch(PDO::FETCH_ASSOC);

        return $response->withJson($results);
    }
}