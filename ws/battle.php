<?php

use function DI\get;
use Kitty\Battle\Commands\BattleStart;
use Kitty\Battle\Commands\EnterQueue;
use Kitty\Battle\Commands\TakeTurn;
use Kitty\Battle\Entities\Skills\BaseSkill;
use Kitty\Battle\Events\BattleAction;
use Kitty\Battle\Events\BattleHasBegun;
use Kitty\Battle\Events\BattleHasEnded;
use Kitty\Battle\Events\BattleUpdate;
use Kitty\Battle\Events\PlayerActionTaken;
use Kitty\Battle\Events\PlayerConnected;
use Kitty\Battle\Events\PlayerQueued;
use Kitty\Battle\Handlers\BattleStartHandler;
use Kitty\Battle\Handlers\EnterQueueHandler;
use Kitty\Battle\Handlers\TakeTurnHandler;
use Kitty\Battle\Services\BattleService;
use Kitty\Battle\Services\CommunicationService;
use Kitty\Battle\Services\KittyBattleService;
use Kitty\Battle\Services\KittyBattleSkillService;
use Kitty\Battle\Services\QueueService;
use Kitty\Battle\Transformers\KittyHydrator;
use Kitty\WebSockets\ConnectionManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;

include_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

$loop = React\EventLoop\Factory::create();

$log = new Monolog\Logger('crypto');

$log->pushHandler(new StreamHandler(__DIR__.'/../logs/websocket-logs.log', Logger::DEBUG));


$kittyBattleSkillService = new KittyBattleSkillService();
$kittyBattleSkillService->addSkill(new BaseSkill(1, 'Claw', 1, 10, 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$kittyBattleSkillService->addSkill(new BaseSkill(2, 'Pounce', 1, 20, 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$kittyBattleSkillService->addSkill(new BaseSkill(3, 'Lick Paws', 1, 0, 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,20,0,0,0,0));

$kittyBattleService = new KittyBattleService($loop, new KittyHydrator($kittyBattleSkillService, $log), $log, [
    'host'      => 'localhost',
    'vhost'     => '/',    // The default vhost is /
    'user'      => getenv('RABBIT_USER'), // The default user is guest
    'password'  => getenv('RABBIT_PASSWORD'), // The default password is guest
]);

$communicationService = new CommunicationService();

$dispatcher = new EventDispatcher();

$battleStartHandler = new BattleStartHandler($dispatcher, $kittyBattleService, $log);
$enterQueueHandler = new EnterQueueHandler($dispatcher);
$takeTurnHandler = new TakeTurnHandler($dispatcher);

$commandBus = League\Tactician\Setup\QuickStart::create(
    [
        BattleStart::class => $battleStartHandler,
        EnterQueue::class => $enterQueueHandler,
        TakeTurn::class => $takeTurnHandler
    ]
);


$queueService = new QueueService($commandBus, $log);
$battleService = new BattleService($dispatcher);

//Wire Events ugh there's a lot of them

//When a player Connects
$dispatcher->addListener(PlayerConnected::EVENT_ROUTING_KEY, [$communicationService, 'onPlayerConnected']);

//When a player is added to the waiting queue
$dispatcher->addListener(PlayerQueued::EVENT_ROUTING_KEY, [$communicationService, 'onPlayerWasQueued']);
$dispatcher->addListener(PlayerQueued::EVENT_ROUTING_KEY, [$queueService, 'onPlayerWasQueued']);

//When a battle is started!
$dispatcher->addListener(BattleHasBegun::EVENT_ROUTING_KEY, [$communicationService, 'onBattleStart']);
$dispatcher->addListener(BattleAction::EVENT_ROUTING_KEY, [$communicationService, 'onBattleAction']);
$dispatcher->addListener(BattleUpdate::EVENT_ROUTING_KEY, [$communicationService, 'onBattleUpdate']);
$dispatcher->addListener(BattleHasEnded::EVENT_ROUTING_KEY, [$communicationService, 'onBattleHasEnded']);

//Battle Service
$dispatcher->addListener(BattleHasBegun::EVENT_ROUTING_KEY, [$battleService, 'onBattleHasBegun']);
$dispatcher->addListener(BattleHasEnded::EVENT_ROUTING_KEY, [$battleService, 'onBattleHasEnded']);
$dispatcher->addListener(PlayerActionTaken::EVENT_ROUTING_KEY, [$battleService, 'onPlayerActionTaken']);



// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App('dna.kitty.fyi', 8080, '0.0.0.0', $loop);
$app->route('/battle', new ConnectionManager($commandBus, $dispatcher), ['*']);
//TODO Add a Service End-Point
$app->run();