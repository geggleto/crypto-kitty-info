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
    /**
     * @var Channel
     */
    private $channel;

    public function __construct(
        Channel $channel,
        $queueName,
        CommandPayload $payload,
        LoggerInterface $logger)
    {
        $this->queue   = $queueName;
        $this->payload = $payload;
        $this->logger = $logger;
        $this->channel = $channel;
    }

    /**
     * @return \React\Promise\Promise|\React\Promise\PromiseInterface
     */
    public function __invoke()
    {
        $corr_id = uniqid($this->queue, true);

        $deferred = new Deferred();

        $this->channel->consume(
            new RpcCommandConsume($deferred, $corr_id, $this->logger),
            $this->queue.'.response',
            $corr_id
        );

        $this->channel->publish(
            \json_encode($this->payload->jsonSerialize()),
            [
                'correlation_id' => $corr_id,
                'reply_to' => $this->queue.'.response',
            ],
            '',
            $this->queue
        );

        return $deferred->promise();
    }
}