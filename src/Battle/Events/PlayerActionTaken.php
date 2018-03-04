<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\PlayerConnection;
use Symfony\Component\EventDispatcher\Event;

class PlayerActionTaken extends Event
{
    public const EVENT_ROUTING_KEY = 'player.take.turn';
    /**
     * @var PlayerConnection
     */
    private $connection;
    private $skill;
    private $battleId;

    public function __construct(PlayerConnection $connection, $skill, $battleId)
    {

        $this->connection = $connection;
        $this->skill = $skill;
        $this->battleId = $battleId;
    }

    /**
     * @return PlayerConnection
     */
    public function getConnection(): PlayerConnection
    {
        return $this->connection;
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