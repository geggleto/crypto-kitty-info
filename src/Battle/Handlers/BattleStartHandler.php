<?php


namespace Kitty\Battle\Handlers;


use Kitty\Battle\Commands\BattleStart;
use Kitty\Battle\Entities\BattleInstance;
use Kitty\Battle\Events\BattleHasBegun;
use React\MySQL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use function random_int;

class BattleStartHandler
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(EventDispatcher $eventDispatcher, Connection $connection)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->connection = $connection;
    }

    public function handle(BattleStart $battleStart) {
        $battle = new BattleInstance(
            $battleStart->getUuid(),
            $battleStart->getPlayer1(),
            $battleStart->getPlayer2(),
            (random_int(0,100)>50)?$battleStart->getPlayer1()->getKittyId() : $battleStart->getPlayer2()->getKittyId()
        );

        $this->eventDispatcher->dispatch(BattleHasBegun::EVENT_ROUTING_KEY, new BattleHasBegun($battle));
    }
}