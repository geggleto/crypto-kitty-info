<?php


namespace Kitty\Battle\Handlers;


use Kitty\Battle\Commands\PlayerLoadKitty;
use Kitty\Battle\Entities\Kitty;
use Kitty\Battle\Events\PlayerLoadedKitty;
use Kitty\Battle\Services\KittyBattleService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class PlayerLoadKittyHandler
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /**
     * @var KittyBattleService
     */
    private $kittyBattleService;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * BattleStartHandler constructor.
     *
     * @param EventDispatcher    $eventDispatcher
     * @param KittyBattleService $kittyBattleService
     * @param LoggerInterface    $logger
     */
    public function __construct(
        EventDispatcher $eventDispatcher,
        KittyBattleService $kittyBattleService,
        LoggerInterface $logger
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->kittyBattleService = $kittyBattleService;
        $this->logger = $logger;
    }

    public function handle(PlayerLoadKitty $command)
    {
        $this->logger->debug('Fetching Kitty for Player '. $command->getKittyId());
        $this->kittyBattleService
            ->fetchKitty($command->getKittyId())
            ->done(function (Kitty $kitty) use ($command) {
                $this->logger->debug('Found Kitty! ' . $kitty->getId());
                $this->eventDispatcher->dispatch(PlayerLoadedKitty::EVENT_ROUTING_KEY, new PlayerLoadedKitty($command->getConnection(), $kitty->toArray()));
            });
    }
}