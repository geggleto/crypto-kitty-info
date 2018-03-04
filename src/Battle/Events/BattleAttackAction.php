<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\BattleInstance;
use Kitty\Battle\Entities\Kitty;
use Symfony\Component\EventDispatcher\Event;

class BattleAttackAction extends BattleAction
{
    /**
     * @var Kitty
     */
    private $attacker;
    /**
     * @var Kitty
     */
    private $defender;

    private $damage;

    public function __construct(BattleInstance $battleInstance, Kitty $attacker, Kitty $defender, $damage)
    {
        parent::__construct($battleInstance);

        $this->attacker = $attacker;
        $this->defender = $defender;
        $this->damage = $damage;
    }

    /**
     * @return Kitty
     */
    public function getAttacker(): Kitty
    {
        return $this->attacker;
    }

    /**
     * @return Kitty
     */
    public function getDefender(): Kitty
    {
        return $this->defender;
    }

    /**
     * @return mixed
     */
    public function getDamage()
    {
        return $this->damage;
    }

    public function __toString() : string
    {
        //<span class="icon has-text-danger">
        //<i class="fas fa-ban"></i>
        //</span>
        return "<span class=\"icon has-text-danger\"><i class=\"fas fa-bolt\"></i></span> #{$this->attacker->getId()} attacked #{$this->defender->getId()} for {$this->damage} damage";
    }
}