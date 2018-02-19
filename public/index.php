<?php

use Kitty\Http\DnaController;
use Kitty\KittyApp;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$app->get('/dna/body/{code"}', [DnaController::class, 'searchBody']);

$app->run();
