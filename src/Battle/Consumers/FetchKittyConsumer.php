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

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(array $values)
    {
        list ($incoming, $channel, $outgoing) = $values;

        $this->logger->debug('Starting Consumer');

        $channel->consume(new KittyRepositories($this->logger), KittyBattleService::FETCH_QUEUE);
    }
}