<?php


namespace Kitty\Battle\Entities;


use Kitty\Battle\Entities\Skills\BaseSkill;
use Kitty\Battle\Entities\Skills\BasicAttack;
use Kitty\Battle\Entities\Skills\Heal;
use Kitty\Battle\Entities\Skills\PowerAttack;
use Kitty\Battle\Services\KittyBattleSkillService;

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

    private $wins;

    private $losses;

    /**
     * Kitty constructor.
     *
     * @param $id
     * @param $health
     * @param $attack
     * @param $defense
     * @param $heal
     * @param $wins
     * @param $losses
     */
    public function __construct(
        $id,
        $health,
        $attack,
        $defense,
        $heal,
        $wins,
        $losses)
    {
        $this->id      = $id;
        $this->health  = $health;
        $this->attack  = $attack;
        $this->defense = $defense;
        $this->maxhealth = $health;
        $this->heal = $heal;

        $this->image_cdn_url = 'https://img.cn.cryptokitties.co/0x06012c8cf97bead5deae237070f9587f8e7a266d/'.$id.'.svg';
        $this->wins = $wins;
        $this->losses = $losses;
    }

    public static function makeKittyFromArray(array $payload)
    {
        return new self(
            $payload['id'],
            $payload['health'],
            $payload['attack'],
            $payload['defense'],
            $payload['heal'],
            $payload['wins'],
            $payload['losses']
        );
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
            'skill1' => $this->skill1->toArray(),
            'skill2' => $this->skill2->toArray(),
            'skill3' => $this->skill3->toArray(),
            'wins' => $this->wins,
            'losses' => $this->losses
        ];
    }

    /**
     * @param BaseSkill $skill1
     */
    public function setSkill1(BaseSkill $skill1): void
    {
        $this->skill1 = $skill1;
    }

    /**
     * @param BaseSkill $skill2
     */
    public function setSkill2(BaseSkill $skill2): void
    {
        $this->skill2 = $skill2;
    }

    /**
     * @param BaseSkill $skill3
     */
    public function setSkill3(BaseSkill $skill3): void
    {
        $this->skill3 = $skill3;
    }


}