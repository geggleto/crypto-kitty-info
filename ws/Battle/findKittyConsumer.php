<?php

use Bunny\Async\Client;
use Kitty\Battle\Consumers\FetchKittyConsumer;
use Kitty\Battle\Services\KittyBattleService;
use Kitty\Infrastructure\CreateAsyncClient;
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

$log->pushHandler(new StreamHandler(__DIR__.'/../../logs/kitty-service-logs.log', Logger::DEBUG));

$loop = Factory::create();

$client = (new CreateAsyncClient($loop, [
    'host'      => 'localhost',
    'vhost'     => '/',    // The default vhost is /
    'user'      => getenv('RABBIT_USER'), // The default user is guest
    'password'  => getenv('RABBIT_PASSWORD'), // The default password is guest
]))()
    ->then(new CreateChannel($log))
    ->then(new DeclareQueue(KittyBattleService::FETCH_QUEUE, $log))
    ->then(new FetchKittyConsumer($log));

$loop->run();