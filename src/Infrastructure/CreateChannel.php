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

    public function __construct(LoopInterface $loop, array $options, LoggerInterface $logger)
    {
        $this->loop = $loop;
        $this->options = $options;
        $this->logger = $logger;
    }

    public function __invoke()
    {
        $this->logger->debug('Creating Channel');

        return (new Client($this->loop, $this->options, $this->logger))->connect()->then(function (Client $client) {

            $this->logger->debug('Client/Channel Created');

            return $client->channel();
        });
    }
}