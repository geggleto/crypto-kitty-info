<?php

use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$service = $container->get(KittyService::class);

var_dump($service->findKittiesFromArray(
    [
        'body' => '__cc'
    ]
));