<?php

use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$kittyService = $container->get(KittyService::class);

var_dump($kittyService->getKittyTable([635272], true, 0.01));