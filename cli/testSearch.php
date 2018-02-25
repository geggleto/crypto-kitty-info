<?php

use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

var_dump(KittyService::getSaleInfo('546937'));