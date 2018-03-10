<?php


namespace Kitty\Battle\Repositories;


use Bunny\Channel;
use Bunny\Async\Client;
use Bunny\Message;
use function json_decode;
use function json_encode;
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

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function ensurePdoIsConnected()
    {
        //Cause the consumer can be running for hours w/o a connection
        //Then MYSQL goes away and boom the consumer dies and the whole system breaks :D
        $this->pdo = new PDO('mysql:host='.getenv('MYSQL_HOST').';dbname='.getenv('MYSQL_DATABASE'), getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'));
    }

    public function __invoke(Message $message, Channel $channel, Client $client) {
        $this->ensurePdoIsConnected();

        $this->logger->debug('Received Message: ' . $message->content);

        $payload = json_decode($message->content, true);

        $statement = $this->pdo->prepare('select * from kitty_battles_kitty where id = ?');

        $statement->execute([$payload['id']]);

        $kitty = $statement->fetch(PDO::FETCH_ASSOC);

        $this->logger->debug('Returning value ' . json_encode($kitty));
        $this->logger->debug($statement->errorCode());
        $this->logger->debug('',$statement->errorInfo());

        $statement->closeCursor();

        $channel->publish(
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