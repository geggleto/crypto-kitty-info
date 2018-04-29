<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\PlayerConnection;
use Symfony\Component\EventDispatcher\Event;

class PlayerConnected extends PlayerEvent
{
    public const EVENT_ROUTING_KEY = 'player.connected';
}