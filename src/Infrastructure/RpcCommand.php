<?php


namespace Kitty\Infrastructure;

use Bunny\Channel;
use Psr\Log\LoggerInterface;
use React\Promise\Deferred;

/**
 * Class FetchCommand
 *
 * This class is called after DeclareFetchQueue and pushes a message to RabbitMq
 *
 * @package Kitty\Infrastructure
 */

class RpcCommand
{
    private $payload;
    private $queue;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct($queueName, CommandPayload $payload, LoggerInterface $logger)
    {
        $this->queue   = $queueName;
        $this->payload = $payload;
        $this->logger = $logger;
    }

    /**
     * @param array $values
     *
     * @return \React\Promise\Promise|\React\Promise\PromiseInterface
     */
    public function __invoke(array $values)
    {
        /** @var $channel Channel */
        list ($responseQueue, $channel) = $values;

        $corr_id = uniqid($this->queue, true);

        $deferred = new Deferred();

        $this->logger->debug('Consuming on ' . $responseQueue->queue.'.response');
        $channel->consume(
            new RpcCommandConsume($deferred, $corr_id, $this->logger),
            $responseQueue->queue.'.response'
        );

        $this->logger->debug('Producing message to ' . $this->queue);
        $channel->publish(
            \json_encode($this->payload->jsonSerialize()),
            [
                'correlation_id' => $corr_id,
                'reply_to' => $responseQueue->queue.'.response',
            ],
            '',
            $this->queue
        );

        return $deferred->promise();
    }
}