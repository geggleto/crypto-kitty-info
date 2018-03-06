<?php


namespace Kitty\Infrastructure;


use Bunny\Async\Client;
use React\EventLoop\LoopInterface;

class CreateChannel
{
    /**
     * @var LoopInterface
     */
    private $loop;

    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
    }

    public function __invoke()
    {
        return (new Client($this->loop))->connect()->then(function (Client $client) {
            return $client->channel();
        });
    }
}