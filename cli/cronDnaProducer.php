<?php

use Bunny\Client;
use Kitty\Consumers\BunnyProducer;
use Kitty\Consumers\DnaConsumer;
use Kitty\KittyApp;
use Kitty\Services\KittyService;

set_time_limit(0);

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(PDO::class);

$statement = $pdo->query('select id from kitties where genes_kai IS null');

$bunny = new Client(
    [
        'host'      => getenv('RABBIT_HOST'),
        'vhost'     => '/',    // The default vhost is /
        'user'      => getenv('RABBIT_USER'), // The default user is guest
        'password'  => getenv('RABBIT_PASSWORD'), // The default password is guest
    ]
);

$producer = new BunnyProducer($bunny, DnaConsumer::ROUTING_KEY);


while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];

    $producer->publish($id);
}