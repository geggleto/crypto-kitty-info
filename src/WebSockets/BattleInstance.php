<?php


namespace Kitty\WebSockets;


use function json_encode;

class BattleInstance
{
    /**
     * @var Player
     */
    private $player1;
    /**
     * @var Player
     */
    private $player2;

    /**
     * @var string
     */
    private $turn;

    private $status;

    private $winner;

    /**
     * BattleInstance constructor.
     *
     * @param Player $player1
     * @param Player $player2
     * @throws \Exception
     */
    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;

        $this->player2->setBattle($this);
        $this->player1->setBattle($this);

        $this->turn = (random_int(1,100) > 50)?$this->player1->getAddress():$this->player2->getAddress();

        $this->status = 'active';
        $this->winner = '';
    }

    /**
     * @return Player
     */
    public function getPlayer1()
    {
        return $this->player1;
    }

    /**
     * @return Player
     */
    public function getPlayer2()
    {
        return $this->player2;
    }

    protected function getBattleCommand()
    {
        return [
            'command' => 'battle',
            'kitty1' => $this->player1->getKitty()->jsonSerialize(),
            'kitty2' => $this->player2->getKitty()->jsonSerialize(),
            'turn' => $this->turn,
            'status' => $this->status,
            'winner' => $this->winner
        ];
    }

    public function takeTurn(Player $player, $skill)
    {
        if ($this->turn !== $player->getAddress()) {
            return false;
        }

        $op = $this->getOpponent($player);


        if ($skill === 1) {
            $skill = $player->getKitty()->getSkill1();
        } else if ($skill === 2) {
            $skill = $player->getKitty()->getSkill2();
        } else if ($skill === 3) {
            $skill = $player->getKitty()->getSkill3();
        }

        if ($skill->getTarget() === 'self') {
            $player->getKitty()->receiveDamage($skill->useSkillTargetSelf($player->getKitty()->getAttack()));
        } else {
            $op->getKitty()->receiveDamage(
                $skill->useSkillTargetEnemy(
                    $player->getKitty()->getAttack(),
                    $op->getKitty()->getDefense()
                )
            );
        }

        $this->turn = $op->getAddress();

        if ($op->getKitty()->getHealth() <= 0) {
            $this->endMatch($player);

            return true;
        }

        $this->sendUpdate();
        return false;
    }

    public function getOpponent(Player $player) {
        if ($this->player1 === $player) {
            return $this->player2;
        }

        return $this->player1;

    }

    public function sendUpdate()
    {
        $this->player1->getConnection()->send(json_encode($this->getBattleCommand()));
        $this->player2->getConnection()->send(json_encode($this->getBattleCommand()));
    }

    /**
     * @return string
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getWinner()
    {
        return $this->winner;
    }

    public function endMatch(Player $winner)
    {
        //Op lost
        $this->turn = '';
        $this->status = 'over';
        $this->winner = $winner->getAddress();

        $this->sendUpdate();
    }

}