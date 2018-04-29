<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\PlayerConnection;
use Symfony\Component\EventDispatcher\Event;

class PlayerActionTaken extends Event
{
    public const EVENT_ROUTING_KEY = 'player.take.turn';

    private $address;
    private $skill;
    private $battleId;
    private $kittyId;

    public function __construct($address, $skill, $battleId, $kittyId)
    {
        $this->address = $address;
        $this->skill = $skill;
        $this->battleId = $battleId;
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