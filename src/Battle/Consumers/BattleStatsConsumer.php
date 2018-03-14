<?php


namespace Kitty\Battle\Consumers;


use Bunny\Client;
use Bunny\Channel;
use Bunny\Message;
use DateTimeImmutable;
use PDO;
use Psr\Log\LoggerInterface;

class BattleStatsConsumer
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
        $this->pdo = new PDO('mysql:host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DATABASE'), getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'));
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function __invoke(Message $message, Channel $channel, Client $client)
    {
        $this->ensurePdoIsConnected();

        $data = json_decode($message->content, true);

        $statement = $this->pdo->prepare('insert into `kitty_usage` (player_id, kitty_id, `timestamp`, `result`, `battle_id`) values(?,?,?,?,?)');

        //Who is the winner?
        $winnerKittyId = $data['winner'];

        //Who does it belong to
        if ($winnerKittyId == $data['player1']['kittyId'])
        {
            //Player 1 winner
            $statement->execute([$data['player1']['address'] , $data['player1']['kittyId'], (new DateTimeImmutable())->format("Y-m-d H:i:s"), '1', $data['uuid'] ]);
            $statement->closeCursor();
            $statement->execute([$data['player2']['address'] , $data['player2']['kittyId'], (new DateTimeImmutable())->format("Y-m-d H:i:s"), '0', $data['uuid'] ]);
            $statement->closeCursor();
        } else {
            //Player 2 Winner
            $statement->execute([$data['player2']['address'] , $data['player2']['kittyId'], (new DateTimeImmutable())->format("Y-m-d H:i:s"), '1', $data['uuid'] ]);
            $statement->closeCursor();
            $statement->execute([$data['player1']['address'] , $data['player1']['kittyId'], (new DateTimeImmutable())->format("Y-m-d H:i:s"), '0', $data['uuid'] ]);
            $statement->closeCursor();
        }

        $channel->ack($message);
    }
}