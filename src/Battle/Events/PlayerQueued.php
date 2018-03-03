<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\PlayerConnection;
use Symfony\Component\EventDispatcher\Event;

class PlayerQueued extends PlayerEvent
{
    public const EVENT_ROUTING_KEY = 'player.queued';
}