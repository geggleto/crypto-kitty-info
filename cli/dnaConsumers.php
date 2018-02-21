<?php

use Bunny\Client;
use Kitty\Consumers\BunnyConsumer;
use Kitty\Consumers\DnaConsumer;
use Kitty\KittyApp;

include_once __DIR__ . '/../vendor/autoload.php';

set_time_limit(0);

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$bunny = new Client(
    [
        'host'      => getenv('RABBIT_HOST'),
        'vhost'     => '/',    // The default vhost is /
        'user'      => getenv('RABBIT_USER'), // The default user is guest
        'password'  => getenv('RABBIT_PASSWORD'), // The default password is guest
    ]
);

$bunnyConsumer = new BunnyConsumer($bunny, $container->get(DnaConsumer::class));
$bunnyConsumer->run();
