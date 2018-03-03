<?php

namespace Kitty\Battle\Entities\Skills;

abstract class BaseSkill
{
    protected $name;

    /**
     * @var int
     */
    protected $power;
    /**
     * @var int
     */
    protected $heal;
    /**
     * @var int
     */
    protected $attackUp;
    /**
     * @var int
     */
    protected $defenseUp;
    /**
     * @var int
     */
    protected $damagePerTurn;
    /**
     * @var int
     */
    protected $cooldown;

    /**
     * BaseSkill constructor.
     *
     * @param     $name
     * @param int $power
     * @param int $heal
     * @param int $attackUp
     * @param int $defenseUp
     * @param int $damagePerTurn
     * @param int $cooldown
     */
    protected function __construct(
        $name,
        $power = 0,
        $heal = 0,
        $attackUp = 0,
        $defenseUp = 0,
        $damagePerTurn = 0,
        $cooldown = 0
    )
    {
        $this->name = $name;
        $this->power = $power;
        $this->heal = $heal;
        $this->attackUp = $attackUp;
        $this->defenseUp = $defenseUp;
        $this->damagePerTurn = $damagePerTurn;
        $this->cooldown = $cooldown;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPower(): int
    {
        return $this->power;
    }

    /**
     * @return int
     */
    public function getHeal(): int
    {
        return $this->heal;
    }

    /**
     * @return int
     */
    public function getAttackUp(): int
    {
        return $this->attackUp;
    }

    /**
     * @return int
     */
    public function getDefenseUp(): int
    {
        return $this->defenseUp;
    }

    /**
     * @return int
     */
    public function getDamagePerTurn(): int
    {
        return $this->damagePerTurn;
    }

    /**
     * @return int
     */
    public function getCooldown(): int
    {
        return $this->cooldown;
    }

}