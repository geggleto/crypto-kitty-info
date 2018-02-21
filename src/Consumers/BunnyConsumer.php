<?php


namespace Kitty\Consumers;


use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use function var_dump;

class BunnyConsumer
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var ConsumerInterface
     */
    private $consumer;

    /**
     * @var Channel
     */
    private $channel;

    public function __construct(Client $client, ConsumerInterface $consumer)
    {
        $this->client = $client;

        $this->client->connect();

        $this->channel = $this->client->channel();

        $this->channel->exchangeDeclare('dlx', 'topic', false, 'true');

        $this->channel->queueDeclare($consumer->getRoutingKey(),false, true, false, false, false, [
            'x-dead-letter-exchange' => 'dlx'
        ]); // Queue name

        $this->channel->queueDeclare($consumer->getRoutingKey().'_dlq', false, true); // Queue name

        $this->channel->queueBind($consumer->getRoutingKey().'_dlq','dlx','*');

        $this->consumer = $consumer;

        $this->channel->qos(
            0, // Prefetch size
            5  // Prefetch count
        );
    }

    public function run() {
        $this->channel->run(
            function (Message $message, Channel $channel, Client $bunny) {

                $consumer = $this->consumer;

                $data = json_decode($message->content, true);

                $success = $consumer($data['args']);

                if ($success) {
                    $channel->ack($message); // Acknowledge message
                    return;
                }

                $channel->reject($message, false); // Mark message fail, message will be redelivered
            },
            $this->consumer->getRoutingKey()
        );
    }
}