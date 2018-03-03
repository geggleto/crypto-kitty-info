<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\PlayerConnection;
use Symfony\Component\EventDispatcher\Event;

abstract class PlayerEvent extends Event
{
    /**
     * @var PlayerConnection
     */
    private $playerConnection;

    public function __construct(PlayerConnection $playerConnection)
    {
        $this->playerConnection = $playerConnection;
    }

    /**
     * @return PlayerConnection
     */
    public function getPlayerConnection()
    {
        return $this->playerConnection;
    }
}