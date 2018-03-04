<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\BattleInstance;
use Kitty\Battle\Entities\Kitty;
use Symfony\Component\EventDispatcher\Event;

class BattleHealAction extends BattleAction
{
    /**
     * @var Kitty
     */
    private $kitty;
    private $healed;

    public function __construct(BattleInstance $battleInstance, Kitty $kitty, $healed)
    {
        parent::__construct($battleInstance);
        $this->kitty = $kitty;
        $this->healed = $healed;
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
    public function getHealed()
    {
        return $this->healed;
    }

    public function __toString() : string
    {
        return "#{$this->kitty->getId()} healed for <span class=\"icon has-text-info\"><i class=\"fas fa-medkit\"></i></span> {$this->healed}";
    }
}