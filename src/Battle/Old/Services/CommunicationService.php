<?php


namespace Kitty\Battle\Services;

use function json_encode;
use Kitty\Battle\Events\BattleAction;
use Kitty\Battle\Events\BattleEvent;
use Kitty\Battle\Events\BattleHasBegun;
use Kitty\Battle\Events\BattleHasEnded;
use Kitty\Battle\Events\BattleUpdate;
use Kitty\Battle\Events\PlayerConnected;
use Kitty\Battle\Events\PlayerEvent;
use Kitty\Battle\Events\PlayerLoadedKitty;
use Kitty\Battle\Events\PlayerQueued;
use Kitty\Battle\Events\PlayerRemoved;

class CommunicationService
{
    public function onPlayerWasQueued(PlayerQueued $playerQueued) : void
    {
        $data = $playerQueued->getPlayerConnection()->toArray();
        $data['event'] = PlayerQueued::EVENT_ROUTING_KEY;

        $this->sendPlayerEvent($playerQueued, $data);
    }

    public function onPlayerConnected(PlayerConnected $playerConnected) : void
    {
        $data = $playerConnected->getPlayerConnection()->toArray();
        $data['event'] = PlayerConnected::EVENT_ROUTING_KEY;

        $this->sendPlayerEvent($playerConnected, $data);
    }

    public function onBattleStart(BattleHasBegun $battleEvent) : void
    {
        $data = $battleEvent->getBattleInstance()->toArray();
        $data['event'] = BattleHasBegun::EVENT_ROUTING_KEY;

        $this->sendBattleEvent($battleEvent, $data);
    }

    public function onBattleUpdate(BattleUpdate $battleEvent) : void
    {
        $data = $battleEvent->getBattleInstance()->toArray();
        $data['event'] = BattleUpdate::EVENT_ROUTING_KEY;

        $this->sendBattleEvent($battleEvent, $data);
    }

    public function onBattleAction(BattleAction $battleAction) : void
    {
        $data = [];
        $data['message'] = $battleAction->__toString();
        $data['event'] = BattleAction::EVENT_ROUTING_KEY;

        $this->sendBattleAction($battleAction, $data);
    }

    public function onBattleHasEnded(BattleHasEnded $battleEvent) : void
    {
        $data = $battleEvent->getBattleInstance()->toArray();
        $data['event'] = BattleHasEnded::EVENT_ROUTING_KEY;

        $this->sendBattleEvent($battleEvent, $data);
    }

    public function onPlayerLoadedKitty(PlayerLoadedKitty $loadedKitty)
    {
        $data = [];
        $data['kitty'] = $loadedKitty->getKitty();
        $data['event'] = PlayerLoadedKitty::EVENT_ROUTING_KEY;

        $this->sendPlayerEvent($loadedKitty, $data);
    }

    protected function sendPlayerEvent(PlayerEvent $playerQueued, array $data) : void
    {
        $playerQueued->getPlayerConnection()->getConnection()->send(json_encode($data));
    }

    protected function sendBattleEvent(BattleEvent $battleEvent, array $data) : void
    {
        $battleEvent->getBattleInstance()->getPlayer1()->getConnection()->send(json_encode($data));
        $battleEvent->getBattleInstance()->getPlayer2()->getConnection()->send(json_encode($data));
    }

    protected function sendBattleAction(BattleAction $action, array $data)
    {
        $action->getBattleInstance()->getPlayer1()->getConnection()->send(json_encode($data));
        $action->getBattleInstance()->getPlayer2()->getConnection()->send(json_encode($data));
    }
}