<?php


namespace Kitty\WebSockets;


use Ratchet\ConnectionInterface;

class Player
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    private $address;

    /**
     * @var Kitty
     */
    private $kitty;

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
     * @param ConnectionInterface $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return Kitty
     */
    public function getKitty()
    {
        return $this->kitty;
    }

    /**
     * @param Kitty $kitty
     */
    public function setKitty($kitty)
    {
        $this->kitty = $kitty;
    }

    /**
     * @return BattleInstance
     */
    public function getBattle()
    {
        return $this->battle;
    }

    /**
     * @param BattleInstance $battle
     */
    public function setBattle($battle)
    {
        $this->battle = $battle;
    }




}