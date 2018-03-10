<?php


namespace Kitty\Battle\Services;

use Bunny\Async\Client;
use Bunny\Channel;
use function json_decode;
use Kitty\Battle\Entities\Kitty;
use Kitty\Battle\Transformers\KittyHydrator;
use Kitty\Infrastructure\CommandPayload;
use Kitty\Infrastructure\CreateAsyncClient;
use Kitty\Infrastructure\CreateChannel;
use Kitty\Infrastructure\DeclareQueue;
use Kitty\Infrastructure\RpcCommand;
use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;
use React\Promise\ExtendedPromiseInterface;
use React\Promise\Promise;
use React\Promise\PromiseInterface;

class KittyBattleService
{
    /** @var KittyHydrator */
    private $hydrator;

    public const FETCH_QUEUE = 'kitty.fetch';
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var LoopInterface
     */
    private $loop;
    /**
     * @var array
     */
    private $options;

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
        $this->loop = $loop;
        $this->options = $options;
    }

    /**
     * @param $id
     *
     * @return Promise
     */
    public function fetchKitty($id): PromiseInterface
    {

        return
            (new CreateAsyncClient($this->loop, $this->options))()
                ->then(new CreateChannel($this->logger))
                ->then(new DeclareQueue(self::FETCH_QUEUE, $this->logger))
                ->then(new RpcCommand(
                    new CommandPayload([
                        'id' => $id
                    ]),
                    $this->logger
                ))->then(function ($payload) {
                    return $this->hydrator->hydrate($payload);
                });
    }
}