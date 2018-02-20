<?php

use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$thing = KittyService::getDnaFromContract(45000);

var_dump($thing);