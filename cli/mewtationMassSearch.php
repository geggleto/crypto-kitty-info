<?php

set_time_limit(0);

use GuzzleHttp\Client;
use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$kittyService = $container->get(KittyService::class);

$cattributesJson = file_get_contents('https://api.cryptokitties.co/cattributes');
$cattributes = json_decode($cattributesJson, true);

$pdo = $container->get(PDO::class);

$pdo->query('truncate table `kitty_mewtation_sales`;');

$insert = $pdo->prepare('insert into `kitty_mewtation_sales` (kitty_id, cattribute, `position`, price) VALUES(?,?,?,?);');

foreach ($cattributes as $cattribute) {
    $cat = $cattribute['description'];

    $kitties = $kittyService->getMewtations($cat);

    foreach ($kitties as $kitty) {
        $insert->execute([
             $kitty['id'],
             $cat,
             $kitty['position'],
             $kitty['price']
         ]);
    }

}

print "done\n";

