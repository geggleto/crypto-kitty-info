<?php

use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$service = $container->get(KittyService::class);

$ids = $service->findKittiesFromArray(
    [
        'body' => '__cc',
        'genD' => '2'
    ]
);

print "\n";
var_dump($ids);