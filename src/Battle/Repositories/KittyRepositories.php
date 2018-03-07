<?php


namespace Kitty\Battle\Repositories;


use Bunny\Channel;
use Bunny\Async\Client;
use Bunny\Message;
use function json_decode;
use PDO;
use Psr\Log\LoggerInterface;

class KittyRepositories
{
    /**
     * @var PDO
     */
    private $pdo;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(PDO $PDO, LoggerInterface $logger)
    {
        $this->pdo = $PDO;
        $this->logger = $logger;
    }

    public function __invoke(Message $message, Channel $channel, Client $client) {
        $this->logger->debug('Received Message: ' . $message->content);
        $payload = json_decode($message->content, true);

        $statement = $this->pdo->prepare('select * from kitty_battle_kitty where id = ?');
        $statement->execute([$payload['id']]);

        $kitty = $statement->fetch(PDO::FETCH_ASSOC);

        return $channel->publish(
                json_encode($kitty),
                [
                    'correlation_id' => $message->getHeader('correlation_id'),
                ],
                '',
                $message->getHeader('reply_to')
        )->then(function () use ($channel, $message) {
            $channel->ack($message);
        });
    }
}