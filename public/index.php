<?php

use Kitty\KittyApp;

include_once __DIR__ . '/../vendor/autoload.php';

session_name('ckdi');
session_start();

$app = new KittyApp();

include_once __DIR__ . '/../config/routes.php';

$app->run();
