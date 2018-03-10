<?php


namespace Kitty\Infrastructure;


use Bunny\Async\Client;
use React\EventLoop\LoopInterface;
use React\EventLoop\StreamSelectLoop;

class CreateAsyncClient
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * CreateAsyncClient constructor.
     *
     * @param       $loop
     * @param array $options
     */
    public function __construct(LoopInterface $loop, array $options)
    {
        $this->options = $options;
        $this->loop = $loop;
    }

    /**
     * @return \React\Promise\PromiseInterface
     */
    public function __invoke()
    {
        return (new Client($this->loop, $this->options))->connect();
    }
}