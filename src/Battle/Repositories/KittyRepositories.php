<?php


namespace Kitty\Battle\Repositories;


use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use function json_decode;
use PDO;

class KittyRepositories
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $PDO)
    {
        $this->pdo = $PDO;
    }

    public function __invoke(Message $message, Channel $channel, Client $client) {
        $payload = json_decode($message->content, true);

        $statement = $this->pdo->prepare('select * from kitty_battle_kitty where id = ?');
        $statement->execute([$payload['id']]);

        $message = $statement->fetch(PDO::FETCH_ASSOC);

        return $channel->publish(
                $message,
                [
                    'correlation_id' => $message->getHeader('correlation_id'),
                ],
                '',
                $message->getHeader('reply_to'
            )
        )->then(function () use ($channel, $message) {
            $channel->ack($message);
        });
    }
}