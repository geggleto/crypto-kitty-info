<?php
namespace Kitty\WebSockets;

use function array_filter;
use function array_pop;
use function json_decode;
use Kitty\WebSockets\Skills\PowerAttack;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use function var_dump;

class CryptoBattle implements MessageComponentInterface
{
    /** @var \SplObjectStorage|Player[] */
    protected $clients;

    /** @var Player[] */
    protected $queue;

    /** @var BattleInstance[] */
    protected $battles;

    public function __construct() { //Probably need to include bunny
        $this->clients = new \SplObjectStorage();
        $this->queue = [];
        $this->battles = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach(new Player($conn));
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $player = $this->findPlayer($from);

        if ($player === null) {
            return;
        }

        $messagePacket = json_decode($msg, true);

        if ($messagePacket !== false) {
            //Command from Player
            if ($messagePacket['command'] === 'IdentifyPlayer') {
                //This message should contain a Player Address and Kitty id

                $player->setAddress($messagePacket['address']);
                $player->setKitty(
                    Kitty::makeKitty($messagePacket['kittyId'])
                );

                $this->queue[] = $player;

                $this->matchPlayer();

            } else if ($messagePacket['command'] === 'TakeTurn') {

                $skill = $messagePacket['skill'];
                $result = $player->getBattle()->takeTurn($player, $skill);

                if (!$result && $player->getBattle()->getStatus() === 'over') {
                    $this->battleCleanUp($player);
                }
            }

            var_dump($messagePacket);
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->detachPlayer($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $this->detachPlayer($conn);
        $conn->close();
    }

    protected function detachPlayer(ConnectionInterface $conn) {
        $player = $this->findPlayer($conn);

        if ($player !== null) {
            $this->battleCleanUp($player);
            $this->clients->detach($player);
        }
    }

    protected function findPlayer(ConnectionInterface $connection) {
        foreach ($this->clients as $client) {
            if ($client->getConnection() === $connection) {
                return $client;
            }
        }

        return null;
    }

    protected function matchPlayer()
    {
        while (count($this->queue) >= 2) {
            $player1 = array_pop($this->queue);
            $player2 = array_pop($this->queue);

            $this->battles[] = new BattleInstance($player1, $player2);
        }
    }

    protected function battleCleanUp(Player $player)
    {
        $battle = $player->getBattle();
        $op = $battle->getOpponent($player);
        $battle->endMatch($op);

        $battle->getPlayer2()->setBattle(null);
        $player->setBattle(null);

        $this->battles = array_filter($this->battles, function (BattleInstance $battle) {
            return $battle->getStatus() === 'active';
        });
    }
}