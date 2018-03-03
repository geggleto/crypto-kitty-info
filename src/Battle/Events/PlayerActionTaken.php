<?php


namespace Kitty\Battle\Events;


use Kitty\Battle\Entities\PlayerConnection;

class PlayerActionTaken
{
    public const EVENT_ROUTING_KEY = 'player.take.turn';

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