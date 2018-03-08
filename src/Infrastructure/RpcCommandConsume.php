<?php


namespace Kitty\Infrastructure;


use Bunny\Async\Client;
use Bunny\Channel;
use Bunny\Message;
use Psr\Log\LoggerInterface;
use React\Promise\Deferred;

class RpcCommandConsume
{
    private $deferred;
    private $corr_id;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * FetchConsume constructor.
     *
     * @param $deferred
     * @param $corr_id
     */
    public function __construct(Deferred $deferred, $corr_id, LoggerInterface $logger)
    {
        $this->deferred = $deferred;
        $this->corr_id = $corr_id;
        $this->logger = $logger;
    }

    public function __invoke(Message $message, Channel $channel, Client $client) {

        if ($message->getHeader('correlation_id') !== $this->corr_id) {
            return;
        }

        $this->logger->debug('Resolving ' . $message->content);

        $this->deferred->resolve($message->content);

        $channel->ack($message)->done(function () use ($channel) {
            $channel->cancel($this->corr_id);
        });
    }
}