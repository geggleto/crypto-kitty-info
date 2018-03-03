<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\BattleInstance;
use Symfony\Component\EventDispatcher\Event;

abstract class BattleEvent extends Event
{
    /**
     * @var BattleInstance
     */
    private $battleInstance;

    public function __construct(BattleInstance $battleInstance)
    {
        $this->battleInstance = $battleInstance;
    }

    /**
     * @return BattleInstance
     */
    public function getBattleInstance(): BattleInstance
    {
        return $this->battleInstance;
    }
}