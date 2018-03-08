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
        array $options
    )
    {
        $this->hydrator = $kittyHydrator;
        $this->logger = $logger;

        (new CreateChannel($loop, $options, $logger))()
            ->then(new DeclareQueue(self::FETCH_QUEUE, $this->logger))
            ->done(function ($values) {
                list (,$channel,) = $values;
                $this->setChannel($channel);
            });
    }

    private function setChannel(Channel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * @param $id
     *
     * @return Promise
     */
    public function fetchKitty($id): PromiseInterface
    {
        $this->logger->debug('Fetching kitty'. $id);

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