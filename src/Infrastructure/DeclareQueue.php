<?php


namespace Kitty\Infrastructure;


use Bunny\Channel;
use Psr\Log\LoggerInterface;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * DeclareKittyFetchQueue constructor.
     *
     * @param string $queueName
     */
    public function __construct($queueName = '', LoggerInterface $logger)
    {
        $this->queueName = $queueName;
        $this->logger = $logger;
    }

    /**
     * @param Channel $channel
     *
     * @return \React\Promise\Promise
     */
    public function __invoke(Channel $channel)
    {
        $this->logger->debug('Attempting Declare Queue');

        return \React\Promise\all([
            $channel->queueDeclare($this->queueName, false, true, false),
            \React\Promise\resolve($channel),
            $channel->queueDeclare('', false, true, false),
        ]);
    }
}