<?php


namespace Kitty\Battle\Events;


class BattleHasEnded extends BattleEvent
{
    public const EVENT_ROUTING_KEY = 'battle.ended';

}