<?php


namespace Kitty\Battle\Consumers;


use Bunny\Channel;
use Kitty\Battle\Repositories\KittyRepositories;
use Kitty\Battle\Services\KittyBattleService;

class FetchKittyConsumer
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function __invoke(Channel $channel)
    {
        $channel->consume(new KittyRepositories($this->pdo), KittyBattleService::FETCH_QUEUE);
    }
}