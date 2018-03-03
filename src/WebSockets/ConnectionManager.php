<?php
namespace Kitty\WebSockets;

use Kitty\Battle\Commands\EnterQueue;
use Kitty\Battle\Commands\TakeTurn;
use Kitty\Battle\Entities\PlayerConnection;
use Kitty\Battle\Events\PlayerConnected;
use League\Tactician\CommandBus;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use React\MySQL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcher;
use function json_decode;

class ConnectionManager implements MessageComponentInterface
{
    /** @var PlayerConnection[] */
    protected $clients;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(
        Connection $connection,
        CommandBus $commandBus,
        EventDispatcher $dispatcher
    ) {

        $this->clients = [];

        $this->connection = $connection;
        $this->commandBus = $commandBus;
        $this->dispatcher = $dispatcher;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $player = new PlayerConnection($conn);

        $this->clients[] = $player;

        $this->dispatcher->dispatch('player.connected', new PlayerConnected($player));
    }

    public function onMessage(ConnectionInterface $from, $msg) //Receive Command
    {
        $player = $this->findPlayer($from);
        if ($player !== null) {
            $decoded = json_decode($msg, true);

            if ($decoded['command'] === EnterQueue::COMMAND_ROUTING_KEY) {
                //Player wishes to enter the queue with a cat
                $this->commandBus->handle(
                    new EnterQueue(
                        $player,
                        (string)$decoded['address'],
                        (int)$decoded['kittyId']
                    )
                );

            } else if ($decoded['command'] === TakeTurn::COMMAND_ROUTING_KEY) {
                //Player wishes to enter the queue with a cat
                $this->commandBus->handle(
                    new TakeTurn(
                        $player,
                        $decoded['skill'],
                        $decoded['battleId']
                    )
                );
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $player = $this->findPlayer($conn);
        if ($player !== null) {
            $this->removePlayer($player);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $player = $this->findPlayer($conn);
        if ($player !== null) {
            $this->removePlayer($player);
        }
    }

    /**
     * @param ConnectionInterface $connection
     *
     * @return PlayerConnection|null
     */
    protected function findPlayer(ConnectionInterface $connection)
    {
        foreach ($this->clients as $playerConnection) {
            if ($playerConnection->getConnection() === $connection) {
                return $playerConnection;
            }
        }

        return null;
    }

    protected function removePlayer(PlayerConnection $playerConnection)
    {
        $value = false;
        foreach ($this->clients as $i => $player) {
            if ($playerConnection === $player) {
                $value = $i;
                break;
            }
        }
        if ($value) {
            unset($this->clients[$value]);
        }


        $this->dispatcher->dispatch('player.removed', new PlayerConnected($playerConnection));
    }


}