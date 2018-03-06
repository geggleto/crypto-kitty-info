<?php

namespace Kitty\Battle\Entities\Skills;

use Kitty\Battle\Entities\Kitty;

class BaseSkill
{
    protected $id;

    protected $name;

    protected $tier;

    protected $attack_up;

    protected $attack_down;

    protected $defense_up;

    protected $defense_down;

    protected $haste;

    protected $slow;

    protected $burning;

    protected $poisoned;

    protected $freezing;

    protected $sleep;

    protected $confused;

    protected $stunned;

    protected $accuracy_up;

    protected $accuracy_down;

    protected $crit_up;

    protected $crit_down;

    protected $heal_power;

    protected $heal_over_time;

    protected $blind;

    protected $evade_up;

    protected $evade_down;

    protected $log;

    protected $power;

    /**
     * BaseSkill constructor.
     *
     * @param $id
     * @param $name
     * @param $tier
     * @param $attack_up
     * @param $attack_down
     * @param $defense_up
     * @param $defense_down
     * @param $haste
     * @param $slow
     * @param $burning
     * @param $poisoned
     * @param $freezing
     * @param $sleep
     * @param $confused
     * @param $stunned
     * @param $accuracy_up
     * @param $accuracy_down
     * @param $crit_up
     * @param $crit_down
     * @param $heal_power
     * @param $heal_over_time
     * @param $blind
     * @param $evade_up
     * @param $evade_down
     */
    public function __construct($id, $name, $tier, $power, $attack_up, $attack_down, $defense_up, $defense_down, $haste, $slow, $burning, $poisoned, $freezing, $sleep, $confused, $stunned, $accuracy_up, $accuracy_down, $crit_up, $crit_down, $heal_power, $heal_over_time, $blind, $evade_up, $evade_down)
    {
        $this->id             = $id;
        $this->name           = $name;
        $this->tier           = $tier;
        $this->attack_up      = $attack_up;
        $this->attack_down    = $attack_down;
        $this->defense_up     = $defense_up;
        $this->defense_down   = $defense_down;
        $this->haste          = $haste;
        $this->slow           = $slow;
        $this->burning        = $burning;
        $this->poisoned       = $poisoned;
        $this->freezing       = $freezing;
        $this->sleep          = $sleep;
        $this->confused       = $confused;
        $this->stunned        = $stunned;
        $this->accuracy_up    = $accuracy_up;
        $this->accuracy_down  = $accuracy_down;
        $this->crit_up        = $crit_up;
        $this->crit_down      = $crit_down;
        $this->heal_power     = $heal_power;
        $this->heal_over_time = $heal_over_time;
        $this->blind          = $blind;
        $this->evade_up       = $evade_up;
        $this->evade_down     = $evade_down;
        $this->power = $power;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getTier()
    {
        return $this->tier;
    }

    /**
     * @return mixed
     */
    public function getAttackUp()
    {
        return $this->attack_up;
    }

    /**
     * @return mixed
     */
    public function getAttackDown()
    {
        return $this->attack_down;
    }

    /**
     * @return mixed
     */
    public function getDefenseUp()
    {
        return $this->defense_up;
    }

    /**
     * @return mixed
     */
    public function getDefenseDown()
    {
        return $this->defense_down;
    }

    /**
     * @return mixed
     */
    public function getHaste()
    {
        return $this->haste;
    }

    /**
     * @return mixed
     */
    public function getSlow()
    {
        return $this->slow;
    }

    /**
     * @return mixed
     */
    public function getBurning()
    {
        return $this->burning;
    }

    /**
     * @return mixed
     */
    public function getPoisoned()
    {
        return $this->poisoned;
    }

    /**
     * @return mixed
     */
    public function getFreezing()
    {
        return $this->freezing;
    }

    /**
     * @return mixed
     */
    public function getSleep()
    {
        return $this->sleep;
    }

    /**
     * @return mixed
     */
    public function getConfused()
    {
        return $this->confused;
    }

    /**
     * @return mixed
     */
    public function getStunned()
    {
        return $this->stunned;
    }

    /**
     * @return mixed
     */
    public function getAccuracyUp()
    {
        return $this->accuracy_up;
    }

    /**
     * @return mixed
     */
    public function getAccuracyDown()
    {
        return $this->accuracy_down;
    }

    /**
     * @return mixed
     */
    public function getCritUp()
    {
        return $this->crit_up;
    }

    /**
     * @return mixed
     */
    public function getCritDown()
    {
        return $this->crit_down;
    }

    /**
     * @return mixed
     */
    public function getHealPower()
    {
        return $this->heal_power;
    }

    /**
     * @return mixed
     */
    public function getHealOverTime()
    {
        return $this->heal_over_time;
    }

    /**
     * @return mixed
     */
    public function getBlind()
    {
        return $this->blind;
    }

    /**
     * @return mixed
     */
    public function getEvadeUp()
    {
        return $this->evade_up;
    }

    /**
     * @return mixed
     */
    public function getEvadeDown()
    {
        return $this->evade_down;
    }

    public function apply(Kitty $friend, Kitty $enemy)
    {
        //TODO Apply skill

    }

    public function applyAll(array $friends, array $enemies)
    {
        //TODO Apply All skill


    }

    public function toArray()
    {
        //TODO Serialize Skill

        return [];
    }


}