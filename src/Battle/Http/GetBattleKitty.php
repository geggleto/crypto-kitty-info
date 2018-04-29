<?php


namespace Kitty\Battle\Http;


use PDO;

class GetBattleKitty
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * GetBattleKitty constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}