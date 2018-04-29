<?php


namespace Kitty\Battle\Handlers;


use Kitty\Battle\Commands\EnterQueue;
use Kitty\Battle\Events\PlayerQueued;
use Kitty\Battle\Services\QueueService;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EnterQueueHandler
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /**
     * @var QueueService
     */
    private $queueService;

    public function __construct(
        EventDispatcher $eventDispatcher
    )
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handle(EnterQueue $enterQueue)
    {
        $player = $enterQueue->getPlayerConnection();
        $player->setAddress($enterQueue->getAddress());
        $player->setKittyId($enterQueue->getKittyId());

        $this->eventDispatcher->dispatch(PlayerQueued::EVENT_ROUTING_KEY, new PlayerQueued($player));
    }
}