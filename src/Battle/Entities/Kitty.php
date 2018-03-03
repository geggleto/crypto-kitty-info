<?php


namespace Kitty\Battle\Entities;


use Kitty\Battle\Entities\Skills\BaseSkill;
use Kitty\Battle\Entities\Skills\BasicAttack;
use Kitty\Battle\Entities\Skills\Heal;
use Kitty\Battle\Entities\Skills\PowerAttack;

class Kitty
{
    /** @var int */
    private $id;

    /** @var int */
    private $health;

    /** @var int */
    private $attack;

    /** @var int */
    private $defense;

    /** @var BaseSkill */
    private $skill1;

    /** @var BaseSkill */
    private $skill2;

    /** @var BaseSkill */
    private $skill3;

    /** @var int */
    private $maxhealth;

    /** @var int */
    private $heal;

    /** @var string */
    private $image_cdn_url;

    /**
     * Kitty constructor.
     *
     * @param           $id
     * @param           $health
     * @param           $attack
     * @param           $defense
     * @param           $heal
     * @param BaseSkill $skill1
     * @param BaseSkill $skill2
     * @param BaseSkill $skill3
     */
    public function __construct(
        $id,
        $health,
        $attack,
        $defense,
        $heal,
        BaseSkill $skill1,
        BaseSkill $skill2,
        BaseSkill $skill3)
    {
        $this->id      = $id;
        $this->health  = $health;
        $this->attack  = $attack;
        $this->defense = $defense;
        $this->skill1  = $skill1;
        $this->skill2  = $skill2;
        $this->skill3  = $skill3;
        $this->maxhealth = $health;
        $this->heal = $heal;
        $this->image_cdn_url = 'https://img.cn.cryptokitties.co/0x06012c8cf97bead5deae237070f9587f8e7a266d/'.$id.'.svg';
    }

    public static function makeKitty($id)
    {
        return new self($id, 100, 10,10, 10, new BasicAttack(), new PowerAttack(), new Heal());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * @return int
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * @return int
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * @return BaseSkill
     */
    public function getSkill1()
    {
        return $this->skill1;
    }

    /**
     * @return BaseSkill
     */
    public function getSkill2()
    {
        return $this->skill2;
    }

    /**
     * @return BaseSkill
     */
    public function getSkill3()
    {
        return $this->skill3;
    }

    public function receiveAttack($amount)
    {
        $this->health -= $amount;
    }

    public function receiveHeal($amount)
    {
        $this->health += $amount;
    }

    public function receiveAttackUp($amount)
    {
        $this->attack += $amount;
    }

    public function receiveDefenseUp($amount)
    {
        $this->defense += $amount;
    }

    public function receiveDamageOverTime($amount)
    {
        //Nothing yet
    }

    /**
     * @return int
     */
    public function getMaxhealth(): int
    {
        return $this->maxhealth;
    }

    /**
     * @return int
     */
    public function getHeal(): int
    {
        return $this->heal;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'attack' => $this->attack,
            'defense' => $this->defense,
            'health' => $this->health,
            'maxhealth' => $this->maxhealth,
            'heal' => $this->heal,
            'image' => $this->image_cdn_url,
            'skill1' => $this->skill1->getName(),
            'skill2' => $this->skill2->getName(),
            'skill3' => $this->skill3->getName(),
            'skill1tier' => 1,
            'skill2tier' => 1,
            'skill3tier' => 1,
            'wins' => '?',
            'losses' => '?'
        ];
    }

}