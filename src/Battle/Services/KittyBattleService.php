<?php


namespace Kitty\Battle\Services;

use Bunny\Async\Client;
use Bunny\Channel;
use function json_decode;
use Kitty\Battle\Entities\Kitty;
use Kitty\Battle\Transformers\KittyHydrator;
use Kitty\Infrastructure\CommandPayload;
use Kitty\Infrastructure\CreateChannel;
use Kitty\Infrastructure\DeclareQueue;
use Kitty\Infrastructure\RpcCommand;
use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;
use React\Promise\Promise;
use React\Promise\PromiseInterface;

class KittyBattleService
{
    /** @var Channel */
    private $channel;

    /** @var KittyHydrator */
    private $hydrator;

    public const FETCH_QUEUE = 'kitty.fetch';
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * KittyBattleService constructor.
     *
     * @param LoopInterface   $loop
     * @param KittyHydrator   $kittyHydrator
     * @param LoggerInterface $logger
     * @param array           $options
     */
    public function __construct(
        LoopInterface $loop,
        KittyHydrator $kittyHydrator,
        LoggerInterface $logger,
        Client $client
    )
    {
        $this->hydrator = $kittyHydrator;
        $this->logger = $logger;

        $this->logger->debug('in constructor kittybattleservice');

        (new CreateChannel($loop, $client, $logger))()
            ->then(function (Channel $channel) {
                $this->setChannel($channel);

                return $channel;
            })
            ->done(new DeclareQueue(self::FETCH_QUEUE, $this->logger));
    }

    private function setChannel(Channel $channel)
    {
        $this->logger->debug('Setting Channel in Kitty Battle Service');
        $this->channel = $channel;
    }

    /**
     * @param $id
     *
     * @return Promise
     */
    public function fetchKitty($id): PromiseInterface
    {
        $this->logger->debug('Fetching kitty in kitty battle service'. $id);

        return (new RpcCommand(
                    $this->channel,
                    self::FETCH_QUEUE,
                    new CommandPayload([
                        'id' => $id
                    ]),
                    $this->logger
                )
            )()->then(function ($payload) {
                return $this->hydrator->hydrate($payload);
            });
    }
}