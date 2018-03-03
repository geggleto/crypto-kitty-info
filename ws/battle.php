<?php

use function DI\get;
use Kitty\Battle\Commands\BattleStart;
use Kitty\Battle\Commands\EnterQueue;
use Kitty\Battle\Commands\IdentifyPlayerAndKittyCommand;
use Kitty\Battle\Commands\TakeTurn;
use Kitty\Battle\Events\BattleAction;
use Kitty\Battle\Events\BattleHasBegun;
use Kitty\Battle\Events\BattleHasEnded;
use Kitty\Battle\Events\PlayerActionTaken;
use Kitty\Battle\Events\PlayerConnected;
use Kitty\Battle\Events\PlayerQueued;
use Kitty\Battle\Handlers\BattleStartHandler;
use Kitty\Battle\Handlers\EnterQueueHandler;
use Kitty\Battle\Handlers\IdentifyPlayerAndKittyHandler;
use Kitty\Battle\Handlers\TakeTurnHandler;
use Kitty\Battle\Services\BattleService;
use Kitty\Battle\Services\CommunicationService;
use Kitty\Battle\Services\QueueService;
use Kitty\WebSockets\BattleManager;
use Kitty\WebSockets\ConnectionManager;
use Kitty\WebSockets\PlayerManager;
use Kitty\WebSockets\PlayerQueueManager;
use React\MySQL\Connection;
use Symfony\Component\EventDispatcher\EventDispatcher;

include_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

$options = array(
    'host'   => getenv('MYSQL_HOST'),
    'port'   => 3306,
    'user'   => getenv('MYSQL_USERNAME'),
    'passwd' => getenv('MYSQL_PASSWORD'),
    'dbname' => getenv('MYSQL_DATABASE'),
);

$loop = React\EventLoop\Factory::create();

//MySql
$connection = new Connection($loop, $options);

$communicationService = new CommunicationService();

$dispatcher = new EventDispatcher();

$battleStartHandler = new BattleStartHandler($dispatcher, $connection);
$enterQueueHandler = new EnterQueueHandler($dispatcher);
$takeTurnHandler = new TakeTurnHandler($dispatcher);

$commandBus = League\Tactician\Setup\QuickStart::create(
    [
        BattleStart::class => $battleStartHandler,
        EnterQueue::class => $enterQueueHandler,
        TakeTurn::class => $takeTurnHandler
    ]
);


$queueService = new QueueService($commandBus);
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

//Battle Service
$dispatcher->addListener(BattleHasBegun::EVENT_ROUTING_KEY, [$battleService, 'onBattleHasBegun']);
$dispatcher->addListener(BattleHasEnded::EVENT_ROUTING_KEY, [$battleService, 'onBattleHasEnded']);
$dispatcher->addListener(PlayerActionTaken::EVENT_ROUTING_KEY, [$battleService, 'onPlayerActionTaken']);


// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App('dna.kitty.fyi', 8080, '0.0.0.0', $loop);
$app->route('/battle', new ConnectionManager($connection, $commandBus, $dispatcher), ['*']);
$app->run();