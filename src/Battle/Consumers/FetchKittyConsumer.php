<?php


namespace Kitty\Battle\Consumers;


use Bunny\Channel;
use Kitty\Battle\Repositories\KittyRepositories;
use Kitty\Battle\Services\KittyBattleService;
use Psr\Log\LoggerInterface;

class FetchKittyConsumer
{
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(\PDO $pdo, LoggerInterface $logger)
    {
        $this->pdo = $pdo;
        $this->logger = $logger;
    }

    public function __invoke(array $values)
    {
        list ($responseQueue, $channel) = $values;

        $this->logger->debug('Starting Consumer');

        $channel->consume(new KittyRepositories($this->pdo, $this->logger), KittyBattleService::FETCH_QUEUE);
    }
}