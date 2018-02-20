<?php

use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$ids = KittyService::getAllKittiesOnProfile('0xcecddbe88359f6ecebe90b42643b002543f27fe9');

var_dump($ids);