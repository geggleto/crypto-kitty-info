<?php


namespace Kitty\Battle\Producer;


use Kitty\Battle\Events\BattleHasEnded;
use Kitty\Infrastructure\CommandPayload;
use Kitty\Infrastructure\CommandProducer;
use Kitty\Infrastructure\CreateAsyncClient;
use Kitty\Infrastructure\CreateChannel;
use Kitty\Infrastructure\DeclareQueue;
use Kitty\Infrastructure\RpcCommand;
use Psr\Log\LoggerInterface;
use React\EventLoop\LoopInterface;

class BattleUsageProducer
{
    public const FETCH_QUEUE = 'battle.stats';
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

    public function onBattleHasEnded(BattleHasEnded $battleHasEnded)
    {
       (new CreateAsyncClient($this->loop, $this->options))()
            ->then(new CreateChannel($this->logger))
            ->then(new DeclareQueue(self::FETCH_QUEUE, $this->logger))
            ->then(new CommandProducer(
                       new CommandPayload(
                           $battleHasEnded->getBattleInstance()->toArray()
                       ),
                       $this->logger
                   ))
            ->done(function (){

            });
    }
}