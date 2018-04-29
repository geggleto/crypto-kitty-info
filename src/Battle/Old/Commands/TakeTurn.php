<?php


namespace Kitty\Battle\Commands;


use Kitty\Battle\Entities\PlayerConnection;

class TakeTurn
{
    const COMMAND_ROUTING_KEY = 'player.take.turn';
    /**
     * @var PlayerConnection
     */
    private $player;
    private $skill;
    private $battleId;


    /**
     * TakeTurn constructor.
     *
     * @param PlayerConnection $player
     * @param                  $skill
     * @param                  $battleId
     */
    public function __construct(PlayerConnection $player, $skill, $battleId)
    {

        $this->player = $player;
        $this->skill = $skill;
        $this->battleId = $battleId;
    }

    /**
     * @return PlayerConnection
     */
    public function getPlayer(): PlayerConnection
    {
        return $this->player;
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