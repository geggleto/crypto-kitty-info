<?php


namespace Kitty\Infrastructure;


use Bunny\Async\Client;
use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;

class CreateChannel
{
    /**
     * @var LoopInterface
     */
    private $loop;
    /**
     * @var array
     */
    private $options;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var Client
     */
    private $client;

    public function __construct(LoopInterface $loop, Client $client, LoggerInterface $logger)
    {
        $this->loop = $loop;
        $this->logger = $logger;
        $this->client = $client;
    }

    public function __invoke()
    {
        $this->logger->debug('Creating Channel');

        return $this->client->connect()->then(function (Client $client) {

            $this->logger->debug('Client/Channel Created');

            return $client->channel();
        });
    }
}