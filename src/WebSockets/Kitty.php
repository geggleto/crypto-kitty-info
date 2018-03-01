<?php


namespace Kitty\WebSockets;


use Kitty\WebSockets\Skills\BaseSkill;
use Kitty\WebSockets\Skills\BasicAttack;
use Kitty\WebSockets\Skills\Heal;
use Kitty\WebSockets\Skills\PowerAttack;

class Kitty implements \JsonSerializable
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

    /**
     * Kitty constructor.
     *
     * @param $id
     * @param $health
     * @param $attack
     * @param $defense
     * @param $skill1
     * @param $skill2
     * @param $skill3
     */
    public function __construct($id, $health, $attack, $defense, BaseSkill $skill1, BaseSkill $skill2, BaseSkill $skill3)
    {
        $this->id      = $id;
        $this->health  = $health;
        $this->attack  = $attack;
        $this->defense = $defense;
        $this->skill1  = $skill1;
        $this->skill2  = $skill2;
        $this->skill3  = $skill3;
    }

    public static function makeKitty($id)
    {
        return new self($id, 100, 10,10, new BasicAttack(0, 'target'), new PowerAttack(4,'target'), new Heal(5, 'self'));
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'health' => $this->health,
            'attack' => $this->attack,
            'defense' => $this->defense,
            'skill1' => $this->skill1->jsonSerialize(),
            'skill2' => $this->skill2->jsonSerialize()
        ];
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

    public function receiveDamage($damage) {
        $this->health += $damage;
    }

}