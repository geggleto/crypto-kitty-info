<?php

use GuzzleHttp\Client;
use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

/** @var $kittyService KittyService */
$kittyService = $container->get(KittyService::class);

print $kittyService->getMaximumKittyFromContract();
