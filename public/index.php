<?php

use Kitty\Http\DnaController;
use Kitty\Http\HomePage;
use Kitty\Http\ProfileController;
use Kitty\KittyApp;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$app->get('/dna/body/{code}', [DnaController::class, 'searchBody']);
$app->get('/dna/body/color/{code}', [DnaController::class, 'searchBodyColor']);

$app->get('/dna/pattern/{code}', [DnaController::class, 'searchPattern']);
$app->get('/dna/pattern/color/{code}', [DnaController::class, 'searchPatternColor']);
$app->get('/dna/eye/color/{code}', [DnaController::class, 'searchEyeColor']);
$app->get('/dna/eye/type/{code}', [DnaController::class, 'searchEyeType']);

$app->get('/dna/secondary/color/{code}', [DnaController::class, 'searchSecondaryColor']);

$app->get('/dna/wild/{code}', [DnaController::class, 'searchWild']);

$app->get('/dna/mouth/{code}', [DnaController::class, 'searchMouth']);

$app->get('/dna/kitty/{kittenId}', [DnaController::class, 'searchForKitten']);
$app->get('/dna/kitty/{kittenId}/pretty', [DnaController::class, 'searchForKittenPretty']);

$app->get('/dna/profile/{profile}', ProfileController::class);

$app->get('/dna/profile/{profile}/csv', [ProfileController::class, 'exportToCsv']);

$app->get('/', [HomePage::class]);

$app->run();
