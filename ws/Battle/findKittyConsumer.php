<?php

use Kitty\Battle\Consumers\FetchKittyConsumer;
use Kitty\Battle\Services\KittyBattleService;
use Kitty\Infrastructure\CreateChannel;
use Kitty\Infrastructure\DeclareQueue;
use React\EventLoop\Factory;

include_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__.'/../../');
$dotenv->load();

$pdo = new PDO('mysql:host='.getenv('MYSQL_HOST').';dbname='.getenv('MYSQL_DATABASE'), getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'));

$loop = Factory::create();

$channel = new CreateChannel($loop);
$channel()
    ->then(new DeclareQueue(KittyBattleService::FETCH_QUEUE))
    ->then(new FetchKittyConsumer($pdo));