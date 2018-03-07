<?php


namespace Kitty\Battle\Handlers;


use function GuzzleHttp\Promise\all;
use Kitty\Battle\Commands\BattleStart;
use Kitty\Battle\Entities\BattleInstance;
use Kitty\Battle\Entities\Kitty;
use Kitty\Battle\Events\BattleHasBegun;
use Kitty\Battle\Services\KittyBattleService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use function random_int;

class BattleStartHandler
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

    public function handle(BattleStart $battleStart)
    {
        $battle = new BattleInstance(
            $battleStart->getUuid(),
            $battleStart->getPlayer1(),
            $battleStart->getPlayer2(),
            (random_int(0,100)>50)?$battleStart->getPlayer1()->getKittyId() : $battleStart->getPlayer2()->getKittyId()
        );

        $this->logger->debug('Starting Battle');

        $p1 = $this->kittyBattleService->fetchKitty($battleStart->getPlayer1()->getKittyId())
            ->done(function (Kitty $kitty) use ($battle) {
                $this->logger->debug('Setting Kitty 1');
                $battle->setKitty1($kitty);
            });

        $p2 = $this->kittyBattleService->fetchKitty($battleStart->getPlayer2()->getKittyId())
            ->done(function (Kitty $kitty) use ($battle) {
                $this->logger->debug('Setting Kitty 2');
                $battle->setKitty2($kitty);
            });

        all([
            $p1,
            $p2
        ])->then(function () use ($battle) {
                $this->logger->debug('Starting Battle');
                $this->eventDispatcher->dispatch(BattleHasBegun::EVENT_ROUTING_KEY, new BattleHasBegun($battle));
        });
    }
}