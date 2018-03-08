<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\PlayerConnection;

class PlayerLoadedKitty extends PlayerEvent
{
    public const EVENT_ROUTING_KEY = 'player.loaded.kitty';
    /**
     * @var array
     */
    private $kitty;

    public function __construct(PlayerConnection $playerConnection, array $kitty)
    {
        parent::__construct($playerConnection);
        $this->kitty = $kitty;
    }

    /**
     * @return array
     */
    public function getKitty(): array
    {
        return $this->kitty;
    }
}