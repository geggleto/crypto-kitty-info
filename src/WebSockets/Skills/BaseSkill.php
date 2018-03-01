<?php


namespace Kitty\WebSockets\Skills;


abstract class BaseSkill implements \JsonSerializable
{
    private $cooldown;

    private $cooldownCounter;

    private $target;

    public function __construct($cooldown, $target)
    {
        $this->cooldown = $cooldown;
        $this->cooldownCounter = $cooldown;
        $this->target = $target;
    }

    public function useSkillTargetEnemy($attack, $defense) {
        if ($this->cooldownCounter !== 0) {
            return 0;
        }

        return -1 * $this->getDamage($attack, $defense);
    }

    public function useSkillTargetSelf($attack) {
        if ($this->cooldownCounter !== 0) {
            return 0;
        }

        return $this->getDamage($attack, 0);
    }

    public function turnOver() {
        if ($this->cooldownCounter !== 0) {
            $this->cooldownCounter--;
        }
    }

    /**
     * @return mixed
     */
    public function getCooldown()
    {
        return $this->cooldown;
    }

    /**
     * @return mixed
     */
    public function getCooldownCounter()
    {
        return $this->cooldownCounter;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'cooldown' => $this->getCooldown(),
            'cooldownCounter' => $this->getCooldownCounter()
        ];
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }



    abstract protected function getDamage($attack, $defense);

    abstract public function getName();
}