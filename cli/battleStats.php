<?php

use Bunny\Client;
use Kitty\Battle\Consumers\BattleStatsConsumer;
use Kitty\Battle\Producer\BattleUsageProducer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

set_time_limit(0);

include_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

$log = new Monolog\Logger('crypto');
$log->pushHandler(new StreamHandler(__DIR__.'/../logs/battlestats.log', Logger::DEBUG));


$bunny = new Client(
    [
        'host'      => 'localhost',
        'vhost'     => '/',    // The default vhost is /
        'user'      => getenv('RABBIT_USER'), // The default user is guest
        'password'  => getenv('RABBIT_PASSWORD'), // The default password is guest
    ]
);

$bunny->connect();

$channel = $bunny->channel();

$channel->run(new BattleStatsConsumer($log), BattleUsageProducer::FETCH_QUEUE);
