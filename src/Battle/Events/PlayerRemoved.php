<?php


namespace Kitty\Battle\Events;


class PlayerRemoved extends PlayerEvent
{
    public const EVENT_ROUTING_KEY = 'player.removed';
}