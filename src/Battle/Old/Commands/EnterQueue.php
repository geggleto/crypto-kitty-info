<?php


namespace Kitty\Battle\Commands;


use Kitty\Battle\Entities\PlayerConnection;

class EnterQueue
{
    const COMMAND_ROUTING_KEY = 'enter.queue';

    /**
     * @var PlayerConnection
     */
    private $playerConnection;

    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $kittyId;

    /**
     * EnterQueue constructor.
     *
     * @param PlayerConnection $playerConnection
     * @param string           $address
     * @param int              $kittyId
     */
    public function __construct(PlayerConnection $playerConnection, string $address, int $kittyId)
    {
        $this->playerConnection = $playerConnection;
        $this->address = $address;
        $this->kittyId = $kittyId;
    }

    /**
     * @return PlayerConnection
     */
    public function getPlayerConnection(): PlayerConnection
    {
        return $this->playerConnection;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getKittyId(): int
    {
        return $this->kittyId;
    }


}