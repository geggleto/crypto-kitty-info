<?php


namespace Kitty\Battle\Handlers;


use Kitty\Battle\Commands\TakeTurn;
use Kitty\Battle\Events\PlayerActionTaken;
use Symfony\Component\EventDispatcher\EventDispatcher;

class TakeTurnHandler
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(TakeTurn $command)
    {
        $this->eventDispatcher->dispatch(PlayerActionTaken::EVENT_ROUTING_KEY,
            new PlayerActionTaken(
                $command->getConnection(),
                $command->getSkill(),
                $command->getBattleId()
            )
        );
    }
}