<?php


namespace Kitty\Battle\Services;


use Kitty\Battle\Commands\BattleStart;
use Kitty\Battle\Entities\PlayerConnection;
use Kitty\Battle\Events\PlayerQueued;
use League\Tactician\CommandBus;
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
     * QueueService constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->queue = [];

        $this->commandBus = $commandBus;
    }

    public function onPlayerWasQueued(PlayerQueued $playerQueued)
    {
        $this->addPlayer($playerQueued->getPlayerConnection());
    }

    protected function addPlayer(PlayerConnection $playerConnection) {
        $this->queue[] = $playerConnection;

        while (count($this->queue) >= 2) {
            $player1 = array_pop($this->queue);
            $player2 = array_pop($this->queue);

            $battleId = Uuid::uuid4();


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