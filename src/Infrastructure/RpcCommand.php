<?php


namespace Kitty\Infrastructure;

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

    public function __construct($queueName, CommandPayload $payload)
    {
        $this->queue   = $queueName;
        $this->payload = $payload;
    }

    /**
     * @param array $values
     *
     * @return \React\Promise\Promise|\React\Promise\PromiseInterface
     */
    public function __invoke(array $values)
    {
        list ($responseQueue, $channel) = $values;

        $corr_id = uniqid($this->queue, true);

        $deferred = new Deferred();

        $channel->consume(
            new RpcCommandConsume($deferred, $corr_id),
            $responseQueue->queue
        );

        $channel->publish(
            \json_encode($this->payload->jsonSerialize()),
            [
                'correlation_id' => $corr_id,
                'reply_to' => $responseQueue->queue,
            ],
            '',
            $this->queue
        );

        return $deferred->promise();
    }
}