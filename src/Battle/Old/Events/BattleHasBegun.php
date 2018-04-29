<?php


namespace Kitty\Battle\Events;

class BattleHasBegun extends BattleEvent
{
    public const EVENT_ROUTING_KEY = 'battle.started';
}