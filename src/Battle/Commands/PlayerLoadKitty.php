<?php


namespace Kitty\Battle\Commands;


use Kitty\Battle\Entities\PlayerConnection;

class PlayerLoadKitty
{
    const COMMAND_ROUTING_KEY = 'player.load.kitty';
    /**
     * @var PlayerConnection
     */
    private $connection;
    private $kittyId;

    public function __construct(PlayerConnection $connection, $kittyId)
    {
        $this->connection = $connection;
        $this->kittyId = $kittyId;
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
    public function getKittyId()
    {
        return $this->kittyId;
    }


}