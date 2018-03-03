<?php


namespace Kitty\Battle\Services;


use Kitty\Battle\Entities\BattleInstance;
use Kitty\Battle\Entities\Kitty;
use Kitty\Battle\Entities\Skills\BaseSkill;
use Kitty\Battle\Events\BattleAction;
use Kitty\Battle\Events\BattleAttackAction;
use Kitty\Battle\Events\BattleAttackUpAction;
use Kitty\Battle\Events\BattleDefenseUpAction;
use Kitty\Battle\Events\BattleHasBegun;
use Kitty\Battle\Events\BattleHasEnded;
use Kitty\Battle\Events\BattleHealAction;
use Kitty\Battle\Events\BattleUpdate;
use Kitty\Battle\Events\PlayerActionTaken;
use Symfony\Component\EventDispatcher\EventDispatcher;

class BattleService
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /** @var BattleInstance[] */
    private $battles;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function onBattleHasBegun(BattleHasBegun $battleHasBegun)
    {
        $this->battles[$battleHasBegun->getBattleInstance()->getUuid()->toString()] = $battleHasBegun->getBattleInstance();
    }

    public function onBattleHasEnded(BattleHasEnded $battleHasEnded)
    {
        unset($this->battles[$battleHasEnded->getBattleInstance()->getUuid()->toString()]);
    }

    public function onPlayerActionTaken(PlayerActionTaken $actionTaken)
    {
        if (!isset($this->battles[$actionTaken->getBattleId()])) {
            return;
        }

        $battle = $this->battles[$actionTaken->getBattleId()];

        $attacker = null;
        $defender = null;

        if ($battle->getPlayer1()->getConnection() === $actionTaken->getConnection())
        {
            //Player 1 Attacker
            $attacker = $battle->getKitty1();
            $defender = $battle->getKitty2();
        } else {
            //Player 2 Attacker
            $attacker = $battle->getKitty2();
            $defender = $battle->getKitty1();
        }

        $skill = null;

        if ($actionTaken->getSkill() == 1) {
            $skill = $attacker->getSkill1();
        } else if ($actionTaken->getSkill() == 2) {
            $skill = $attacker->getSkill2();
        } else {
            $skill = $attacker->getSkill3();
        }

        $this->apply($battle, $skill, $attacker, $defender);

        $battle->swapTurn();

        $this->eventDispatcher->dispatch(BattleUpdate::EVENT_ROUTING_KEY, new BattleUpdate($battle));

    }

    protected function apply(
        BattleInstance $battleInstance,
        BaseSkill $skill,
        Kitty $attacker,
        Kitty $defender
    )
    {
        if ($skill->getPower() !== 0) {
            $def = null;
            $atk = null;
            if ($skill->getPower() > 0) {
                //Attacks Defender
                $def = $defender;
                $atk = $attacker;
            } else {
                //Attacks Attacker
                $def = $attacker;
                $atk = $defender;
            }
            $damage = $skill->getPower() + ($atk->getAttack() - $def->getDefense());
            $def->receiveAttack($damage);

            $this->eventDispatcher->dispatch(BattleAction::EVENT_ROUTING_KEY, new BattleAttackAction($battleInstance, $atk, $defender, $damage));
        }

        if ($skill->getHeal() !== 0) {
            $target = null;
            if ($skill->getHeal() > 0) {
                //Heals Attacker
                $target = $attacker;

            } else {
                //Heals Defender
                $target = $defender;
            }

            $heal = $skill->getHeal() + $defender->getHeal();
            $target->receiveHeal($heal);

            $this->eventDispatcher->dispatch(BattleAction::EVENT_ROUTING_KEY, new BattleHealAction($battleInstance, $target, $heal));
        }

        if ($skill->getAttackUp() !== 0) {
            $target = null;
            if ($skill->getAttackUp() > 0) {
                //Heals Attacker
                $target = $attacker;

            } else {
                //Heals Defender
                $target = $defender;
            }

            $target->receiveAttackUp($skill->getAttackUp());

            $this->eventDispatcher->dispatch(BattleAction::EVENT_ROUTING_KEY, new BattleAttackUpAction($battleInstance, $target, $skill->getAttackUp()));
        }

        if ($skill->getDefenseUp() !== 0) {
            $target = null;
            if ($skill->getDefenseUp() > 0) {
                //Heals Attacker
                $target = $attacker;

            } else {
                //Heals Defender
                $target = $defender;
            }

            $target->receiveAttackUp($skill->getDefenseUp());

            $this->eventDispatcher->dispatch(BattleAction::EVENT_ROUTING_KEY, new BattleDefenseUpAction($battleInstance, $target, $skill->getDefenseUp()));
        }
    }
}