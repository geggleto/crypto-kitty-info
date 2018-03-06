<?php


namespace Kitty\Infrastructure;


use Bunny\Channel;

/**
 * Class DeclareFetchQueue
 *
 * This class ensures that the queue exists on your RabbitMQ server
 * It passes forward the queue and channel
 *
 * @package Kitty\Infrastructure
 */
class DeclareQueue
{
    private $queueName;

    /**
     * DeclareKittyFetchQueue constructor.
     *
     * @param string $queueName
     */
    public function __construct($queueName = '')
    {
        $this->queueName = $queueName;
    }

    /**
     * @param Channel $channel
     *
     * @return \React\Promise\Promise
     */
    public function __invoke(Channel $channel)
    {
        return \React\Promise\all([
            $channel->queueDeclare($this->queueName, false, true, false),
            \React\Promise\resolve($channel),
        ]);
    }
}