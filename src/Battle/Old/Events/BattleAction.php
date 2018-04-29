<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\BattleInstance;
use Symfony\Component\EventDispatcher\Event;

class BattleAction extends Event
{
    public const EVENT_ROUTING_KEY = 'battle.action';

    /**
     * @var BattleInstance
     */
    private $battleInstance;
    private $string;

    public function __construct(BattleInstance $battleInstance, $string)
    {
        $this->battleInstance = $battleInstance;
        $this->string = $string;
    }

    /**
     * @return BattleInstance
     */
    public function getBattleInstance(): BattleInstance
    {
        return $this->battleInstance;
    }



    public function __toString() : string
    {
        return $this->string;
    }
}