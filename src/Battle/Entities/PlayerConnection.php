<?php


namespace Kitty\Battle\Entities;


use Ratchet\ConnectionInterface;

class PlayerConnection
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /** @var string */
    private $address;

    /** @var int */
    private $kittyId;

    /** @var BattleInstance */
    private $battle;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getKittyId(): int
    {
        return $this->kittyId;
    }

    /**
     * @param int $kittyId
     */
    public function setKittyId(int $kittyId)
    {
        $this->kittyId = $kittyId;
    }

    public function toArray()
    {
        return [
            'address' => $this->address,
            'kittyId' => $this->kittyId
        ];
    }

    /**
     * @param BattleInstance $battle
     */
    public function setBattle(BattleInstance $battle): void
    {
        $this->battle = $battle;
    }

    /**
     * @return BattleInstance
     */
    public function getBattle(): BattleInstance
    {
        return $this->battle;
    }



}