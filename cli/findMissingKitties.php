<?php

use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

/** @var $kittyService KittyService */
$kittyService = $container->get(KittyService::class);

$contractMax = $kittyService->getMaximumKittyFromContract();

$dbAt = $kittyService->getMaxInDb();

$pdo = $container->get(PDO::class);

$statement = $pdo->prepare('select id from kitties where id = ?');

for ($x=1; $x<=$contractMax; $x++) {
    //print "Loading Kitty: $x\n";

    $statement->execute([$x]);

    if (!$statement->rowCount()) {
        $kittyService->insertKitty($x);
    }
}
