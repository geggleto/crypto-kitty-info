<?php

use GuzzleHttp\Client;
use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

/** @var $kittyService KittyService */
$kittyService = $container->get(KittyService::class);

$contractMax = $kittyService->getMaximumKittyFromContract();

$dbAt = $kittyService->getMaxInDb();

print "Contract At {$contractMax} and Database At : {$dbAt}\n";

for ($x=$dbAt+1; $x<=$contractMax; $x++) {
    print "Loading Kitty: $x\n";

    $kittyService->insertKitty($x);
}
