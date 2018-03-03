<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\BattleInstance;
use Kitty\Battle\Entities\Kitty;
use Symfony\Component\EventDispatcher\Event;

class BattleDefenseUpAction extends BattleAction
{

    /**
     * @var Kitty
     */
    private $kitty;
    private $amount;

    public function __construct(BattleInstance $battleInstance, Kitty $kitty, $amount)
    {
        parent::__construct($battleInstance);

        $this->kitty = $kitty;
        $this->amount = $amount;
    }

    /**
     * @return Kitty
     */
    public function getKitty(): Kitty
    {
        return $this->kitty;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    public function __toString() : string
    {
        return "#{$this->kitty->getId()} increased his Defense by {$this->amount}";
    }
}