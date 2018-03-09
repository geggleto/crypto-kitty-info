<?php


namespace Kitty\Infrastructure;

use Bunny\Channel;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
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
    private $replyTo;

    public function __construct(
        Channel $channel,
        $queueName,
        $replyTo,
        CommandPayload $payload,
        LoggerInterface $logger)
    {
        $this->queue   = $queueName;
        $this->payload = $payload;
        $this->logger = $logger;
        $this->channel = $channel;
        $this->replyTo = $replyTo;
    }

    /**
     * @return \React\Promise\Promise|\React\Promise\PromiseInterface
     */
    public function __invoke()
    {
        $corr_id = Uuid::uuid4();

        $deferred = new Deferred();

        $this->channel->consume(
            new RpcCommandConsume($deferred, $corr_id, $this->logger),
            $this->replyTo,
            $corr_id
        );

        $this->channel->publish(
            \json_encode($this->payload->jsonSerialize()),
            [
                'correlation_id' => $corr_id,
                'reply_to' => $this->replyTo,
            ],
            '',
            $this->queue
        );

        return $deferred->promise();
    }
}