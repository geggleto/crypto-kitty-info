<?php


namespace Kitty\Battle\Commands;


use Kitty\Battle\Entities\PlayerConnection;

class TakeTurn
{
    const COMMAND_ROUTING_KEY = 'player.take.turn';

    private $skill;
    private $battleId;
    private $address;
    private $kittyId;

    public function __construct($address, $skill, $battleId, $kittyId)
    {
        $this->skill = $skill;
        $this->battleId = $battleId;
        $this->address = $address;
        $this->kittyId = $kittyId;
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

    /**
     * @return mixed
     */
    public function getKittyId()
    {
        return $this->kittyId;
    }



}