<?php


namespace Kitty\Security;


use PDO;

class AuthService
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $profile
     *
     * @return bool
     */
    public function authorize($profile)
    {
        $statement = $this->pdo->prepare('select * from authorizations where playerId = ?');

        $statement->execute([$profile]);

        return $statement->rowCount() >= 1;
    }
}