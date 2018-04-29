<?php


namespace Kitty\Battle\Commands;


use Kitty\Battle\Entities\PlayerConnection;
use Ramsey\Uuid\UuidInterface;

class BattleStart
{
    const COMMAND_ROUTING_KEY = 'battle.start';

    /**
     * @var UuidInterface
     */
    private $uuid;
    /**
     * @var PlayerConnection
     */
    private $player1;
    /**
     * @var PlayerConnection
     */
    private $player2;

    public function __construct(
        UuidInterface $uuid,
        PlayerConnection $player1,
        PlayerConnection $player2
    )
    {
        $this->uuid = $uuid;
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return PlayerConnection
     */
    public function getPlayer1(): PlayerConnection
    {
        return $this->player1;
    }

    /**
     * @return PlayerConnection
     */
    public function getPlayer2(): PlayerConnection
    {
        return $this->player2;
    }


}