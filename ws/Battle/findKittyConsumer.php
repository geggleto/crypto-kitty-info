<?php

use Kitty\Battle\Consumers\FetchKittyConsumer;
use Kitty\Battle\Services\KittyBattleService;
use Kitty\Infrastructure\CreateChannel;
use Kitty\Infrastructure\DeclareQueue;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use React\EventLoop\Factory;

include_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__.'/../../');
$dotenv->load();

//Monolog
$log = new Monolog\Logger('crypto');

$log->pushHandler(new StreamHandler(__DIR__.'/../../logs/kitty-service-logs.log', Logger::WARNING));

$pdo = new PDO('mysql:host='.getenv('MYSQL_HOST').';dbname='.getenv('MYSQL_DATABASE'), getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'));

$loop = Factory::create();

$channel = new CreateChannel($loop,[
    'host'      => 'localhost',
    'vhost'     => '/',    // The default vhost is /
    'user'      => getenv('RABBIT_USER'), // The default user is guest
    'password'  => getenv('RABBIT_PASSWORD'), // The default password is guest
],$log);

$channel()
    ->then(new DeclareQueue(KittyBattleService::FETCH_QUEUE))
    ->then(new FetchKittyConsumer($pdo, $log));

$loop->run();