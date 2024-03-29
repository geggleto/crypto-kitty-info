<?php

namespace Kitty\Battle\Entities\Skills;

use Kitty\Battle\Entities\Kitty;
use function random_int;

class BaseSkill
{
    protected $id;

    protected $name;

    protected $tier;

    protected $cooldown;

    protected $timeLeftOnCooldown;

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
     * @param $cooldown
     */
    public function __construct($id, $name, $tier, $power, $attack_up, $attack_down, $defense_up, $defense_down, $haste, $slow, $burning, $poisoned, $freezing, $sleep, $confused, $stunned, $accuracy_up, $accuracy_down, $crit_up, $crit_down, $heal_power, $heal_over_time, $blind, $evade_up, $evade_down, $cooldown)
    {
        $this->id             = (int)$id;
        $this->name           = $name;
        $this->tier           = (int)$tier;
        $this->attack_up      = (int)$attack_up;
        $this->attack_down    = (int)$attack_down;
        $this->defense_up     = (int)$defense_up;
        $this->defense_down   = (int)$defense_down;
        $this->haste          = (int)$haste;
        $this->slow           = (int)$slow;
        $this->burning        = (int)$burning;
        $this->poisoned       = (int)$poisoned;
        $this->freezing       = (int)$freezing;
        $this->sleep          = (int)$sleep;
        $this->confused       = (int)$confused;
        $this->stunned        = (int)$stunned;
        $this->accuracy_up    = (int)$accuracy_up;
        $this->accuracy_down  = (int)$accuracy_down;
        $this->crit_up        = (int)$crit_up;
        $this->crit_down      = (int)$crit_down;
        $this->heal_power     = (int)$heal_power;
        $this->heal_over_time = (int)$heal_over_time;
        $this->blind          = (int)$blind;
        $this->evade_up       = (int)$evade_up;
        $this->evade_down     = (int)$evade_down;
        $this->power          = (int)$power;
        $this->cooldown       = (int)$cooldown;
    }

    public static function makeFromRow($s)
    {
        return new self(
            $s['id'],
            $s['name'],
            $s['tier'],
            $s['power'],
            $s['attack_up'],
            $s['attack_down'],
            $s['defense_up'],
            $s['defense_down'],
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            $s['heal_power'],
            0,
            0,
            0,
            0,
            $s['cooldown']
        );
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

    /**
     * @param Kitty $friend
     * @param Kitty $enemy
     * @return string[]
     */
    public function apply(Kitty $friend, Kitty $enemy)
    {
        $this->timeLeftOnCooldown = $this->cooldown;

        $messages = [];

        //Have to iterate over alllllllll of the things

        if ($this->attack_up != 0) {

            $atkUp = random_int($this->attack_up-2,$this->attack_up+2);

            $skills = $friend->getSkills();
            $skill = random_int(0,count($skills)-1);
            $skills[$skill]->power += $atkUp;

            $messages[] = $friend->getId() . ' ' . $skills[$skill]->getName() . ' power by ' . $atkUp;
        }
        if ($this->attack_down != 0) {

            $atkDown = random_int($this->attack_up-2,$this->attack_up+2);

            $skills = $enemy->getSkills();
            $skill = random_int(0,count($skills)-1);
            $skills[$skill]->power -= $atkDown;

            $messages[] = $friend->getId() . ' lowered enemies ' . $skills[$skill]->getName() . ' power by ' . $atkDown;
        }

        if ($this->haste != 0) {

        }
        if ($this->slow != 0) {

        }
        if ($this->burning != 0) {

        }
        if ($this->poisoned != 0) {

        }
        if ($this->freezing != 0) {

        }
        if ($this->sleep != 0) {

        }
        if ($this->confused != 0) {

        }
        if ($this->stunned != 0) {

        }
        if ($this->accuracy_up != 0) {

        }
        if ($this->accuracy_down != 0) {

        }
        if ($this->crit_up != 0) {

        }
        if ($this->crit_down != 0) {

        }
        if ($this->heal_power != 0) {

            $hp = random_int($this->heal_power-3,$this->heal_power+3);

            $friend->takeDamage(-1 * $hp);
            $messages[] = $friend->getId() . ' healed for ' . $hp;
        }
        if ($this->heal_over_time != 0) {

        }
        if ($this->blind != 0) {

        }
        if ($this->evade_up != 0) {

        }
        if ($this->evade_down != 0) {

        }
        if ($this->power != 0) {

            $damage = random_int($this->power-2,$this->power+2);

            $enemy->takeDamage($damage);
            $messages[] = $friend->getId() . ' attacked for ' . $damage . ' damage';
        }

        return $messages;
    }


    public function decreaseCooldown()
    {
        if ($this->timeLeftOnCooldown > 0) {
            $this->timeLeftOnCooldown--;
        }
    }

    public function toArray()
    {
        $tags = [];

        if ($this->power != 0) {
            $tags['dmg'] = $this->power;
        }

        if ($this->heal_power != 0) {
            $tags['heal'] = $this->heal_power;
        }


        return [
            'name' => $this->name,
            'tier' => $this->tier,
            'cooldown' => $this->cooldown,
            'is_ready' => ($this->timeLeftOnCooldown === 0),
            'countdown' => $this->timeLeftOnCooldown,
            'effects' => $tags
        ];
    }


}