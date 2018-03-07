<?php


namespace Kitty\Infrastructure;


use Bunny\Async\Client;
use Bunny\Channel;
use Bunny\Message;
use React\Promise\Deferred;

class RpcCommandConsume
{
    private $deferred;
    private $corr_id;

    /**
     * FetchConsume constructor.
     *
     * @param $deferred
     * @param $corr_id
     */
    public function __construct(Deferred $deferred, $corr_id)
    {
        $this->deferred = $deferred;
        $this->corr_id = $corr_id;
    }

    public function __invoke(Message $message, Channel $channel, Client $client) {
        if ($message->getHeader('correlation_id') != $this->corr_id) {
            return;
        }

        $this->deferred->resolve($message->content);
        $channel->ack($message);
    }
}