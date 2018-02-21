<?php


namespace Kitty\Consumers;

use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use function var_dump;

class BunnyProducer
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Channel
     */
    private $channel;

    public function __construct(Client $client, $queue)
    {
        $this->client = $client;
        $this->client->connect();
        $this->channel = $this->client->channel();

        $this->channel->exchangeDeclare('dlx', 'topic', false, 'true');

        $this->channel->queueDeclare($queue,false, true, false, false, false, [
            'x-dead-letter-exchange' => 'dlx'
        ]); // Queue name

        $this->channel->queueDeclare($queue . '_dlq', false, true); // Queue name

        $this->channel->queueBind($queue.'_dlq','dlx','*');

        $this->channel->qos(
            0, // Prefetch size
            15  // Prefetch count
        );
    }

    public function publish($x) {
        $this->channel->publish(\json_encode(['args' => ['kittyId' => $x]]),[],'','api');
    }
}