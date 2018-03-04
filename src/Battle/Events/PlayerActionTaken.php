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

    public function __construct($address, $skill, $battleId)
    {

        $this->address = $address;
        $this->skill = $skill;
        $this->battleId = $battleId;
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