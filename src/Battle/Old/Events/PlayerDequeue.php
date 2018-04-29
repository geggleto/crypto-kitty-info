<?php


namespace Kitty\Battle\Events;


class PlayerDequeue extends PlayerEvent
{
    public const EVENT_ROUTING_KEY = 'player.leave.queue';
}