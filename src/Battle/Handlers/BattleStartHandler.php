<?php


namespace Kitty\Battle\Handlers;


use function GuzzleHttp\Promise\all;
use Kitty\Battle\Commands\BattleStart;
use Kitty\Battle\Entities\BattleInstance;
use Kitty\Battle\Entities\Kitty;
use Kitty\Battle\Events\BattleHasBegun;
use Kitty\Battle\Services\KittyBattleService;
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
     * BattleStartHandler constructor.
     *
     * @param EventDispatcher    $eventDispatcher
     * @param KittyBattleService $kittyBattleService
     */
    public function __construct(
        EventDispatcher $eventDispatcher,
        KittyBattleService $kittyBattleService
    )
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->kittyBattleService = $kittyBattleService;
    }

    public function handle(BattleStart $battleStart)
    {
        $battle = new BattleInstance(
            $battleStart->getUuid(),
            $battleStart->getPlayer1(),
            $battleStart->getPlayer2(),
            (random_int(0,100)>50)?$battleStart->getPlayer1()->getKittyId() : $battleStart->getPlayer2()->getKittyId()
        );

        $p1 = $this->kittyBattleService->fetchKitty($battleStart->getPlayer1()->getKittyId())
            ->then(function (Kitty $kitty) use ($battle) {
                $battle->setKitty1($kitty);
            });

        $p2 = $this->kittyBattleService->fetchKitty($battleStart->getPlayer2()->getKittyId())
            ->then(function (Kitty $kitty) use ($battle) {
                $battle->setKitty2($kitty);
            });

        all([
            $p1,
            $p2
        ])->then(function () use ($battle) {
                $this->eventDispatcher->dispatch(BattleHasBegun::EVENT_ROUTING_KEY, new BattleHasBegun($battle));
        });
    }
}