<?php


namespace Kitty\Battle\Commands;


use Kitty\Battle\Entities\PlayerConnection;

class TakeTurn
{
    const COMMAND_ROUTING_KEY = 'player.take.turn';

    private $skill;
    private $battleId;
    private $address;

    public function __construct($address, $skill, $battleId)
    {
        $this->skill = $skill;
        $this->battleId = $battleId;
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @return mixed
     */
    public function getBattleId()
    {
        return $this->battleId;
    }


}