<?php


namespace Kitty\Battle\Entities;


use function json_encode;
use Ramsey\Uuid\UuidInterface;

class BattleInstance
{
    /**
     * @var PlayerConnection
     */
    private $player1;
    /**
     * @var PlayerConnection
     */
    private $player2;

    /**
     * @var string
     */
    private $turn;

    private $status;

    private $winner;

    /**
     * @var UuidInterface
     */
    private $uuid;

    /** @var Kitty */
    private $kitty1;

    /** @var Kitty */
    private $kitty2;

    /**
     * BattleInstance constructor.
     *
     * @param UuidInterface    $uuid
     * @param PlayerConnection $player1
     * @param PlayerConnection $player2
     * @param                  $turn
     */
    public function __construct(
        UuidInterface $uuid,
        PlayerConnection $player1,
        PlayerConnection $player2,
        $turn
    )
    {
        $this->player1 = $player1;
        $this->player2 = $player2;

        $this->turn = $turn;

        $this->status = 'active';
        $this->winner = '';
        $this->uuid = $uuid;
    }

    /**
     * @return PlayerConnection
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @return PlayerConnection
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    /**
     * @return string
     */
    public function getTurn(): string
    {
        return $this->turn;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getWinner(): string
    {
        return $this->winner;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function toArray()
    {
        return [
            'uuid' => $this->uuid->toString(),
            'turn' => $this->turn,
            'status' => $this->status,
            'winner' => $this->winner,
            'kitty1' => $this->kitty1->toArray(),
            'kitty2' => $this->kitty2->toArray(),
            'player1' => $this->getPlayer1()->toArray(),
            'player2' => $this->getPlayer1()->toArray(),
        ];

    }

    /**
     * @return Kitty
     */
    public function getKitty1(): Kitty
    {
        return $this->kitty1;
    }

    /**
     * @return Kitty
     */
    public function getKitty2(): Kitty
    {
        return $this->kitty2;
    }


    public function swapTurn()
    {
        if ($this->turn === $this->kitty1->getId()) {
            $this->turn = $this->kitty2->getId();
        } else {
            $this->turn = $this->kitty1->getId();
        }
    }

    public function endGameWithWinner($winner)
    {
        $this->status = 'ended';
        $this->winner = $winner;
        $this->turn = '';
    }

    /**
     * @param mixed $kitty1
     */
    public function setKitty1($kitty1): void
    {
        $this->kitty1 = $kitty1;
    }

    /**
     * @param mixed $kitty2
     */
    public function setKitty2($kitty2): void
    {
        $this->kitty2 = $kitty2;
    }
}