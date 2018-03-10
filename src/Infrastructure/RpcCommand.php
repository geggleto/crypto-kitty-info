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
    /** @var CommandPayload */
    private $payload;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * RpcCommand constructor.
     *
     * @param CommandPayload  $payload
     * @param LoggerInterface $logger
     */
    public function __construct(
        CommandPayload $payload,
        LoggerInterface $logger)
    {
        $this->payload = $payload;
        $this->logger = $logger;
    }

    /**
     * @return \React\Promise\Promise|\React\Promise\PromiseInterface
     */
    public function __invoke(array $values)
    {
        [$queue, $channel, $replyTo] = $values;

        $corr_id = Uuid::uuid4()->toString();

        $deferred = new Deferred();

        $this->logger->debug('Consuming and publishing ', [
            'queue' => $queue->queue,
            'replyTo' => $replyTo->queue
        ]);

        $channel->consume(
            new RpcCommandConsume($deferred, $corr_id, $this->logger),
            $replyTo->queue,
            $corr_id
        );

        $channel->publish(
            \json_encode($this->payload->jsonSerialize()),
            [
                'correlation_id' => $corr_id,
                'reply_to' => $replyTo->queue,
            ],
            '',
            $queue->queue
        );

        return $deferred->promise();
    }
}