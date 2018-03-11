<?php


namespace Kitty\Battle\Services;


use function array_filter;
use Kitty\Battle\Commands\BattleStart;
use Kitty\Battle\Entities\PlayerConnection;
use Kitty\Battle\Events\PlayerQueued;
use Kitty\Battle\Events\PlayerRemoved;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use function array_pop;

class QueueService
{
    /** @var PlayerConnection[] */
    private $queue;
    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * QueueService constructor.
     *
     * @param CommandBus      $commandBus
     * @param LoggerInterface $logger
     */
    public function __construct(CommandBus $commandBus, LoggerInterface $logger)
    {
        $this->queue = [];

        $this->commandBus = $commandBus;
        $this->logger = $logger;
    }


    /**
     * @param PlayerQueued    $playerQueued
     */
    public function onPlayerWasQueued(PlayerQueued $playerQueued)
    {
        $this->addPlayer($playerQueued->getPlayerConnection());
    }

    public function onPlayerRemoved(PlayerRemoved $playerRemoved)
    {
        $this->removePlayer($playerRemoved->getPlayerConnection());
    }

    protected function removePlayer(PlayerConnection $playerConnection)
    {
        $this->queue = array_filter($this->queue, function (PlayerConnection $connection) use ($playerConnection) {
            return $connection !== $playerConnection;
        });
    }

    protected function addPlayer(PlayerConnection $playerConnection) {
        $this->queue[] = $playerConnection;

        while (count($this->queue) >= 2) {

            $player1 = array_pop($this->queue);
            $player2 = array_pop($this->queue);

            $battleId = Uuid::uuid4();

            $this->logger->debug('starting battle in queue service');
            $this->logger->debug('', $player1->toArray());
            $this->logger->debug('', $player2->toArray());
            $this->logger->debug('end');

            $this->commandBus->handle(
                new BattleStart(
                    $battleId,
                    $player1,
                    $player2
                )
            );
        }
    }

}