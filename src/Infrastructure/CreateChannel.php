<?php


namespace Kitty\Infrastructure;


use Bunny\Async\Client;
use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;

class CreateChannel
{
    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Client $client
     *
     * @return \React\Promise\PromiseInterface
     */
    public function __invoke(Client $client)
    {
        $this->logger->debug('Creating Channel');

        return $client->channel();
    }
}