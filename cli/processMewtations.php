<?php

set_time_limit(0);

use GuzzleHttp\Client;
use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(PDO::class);

for ($x = 0; $x<=8; $x++) {
    print "Processing Position {$x}\n";

    $pdo->query("insert ignore into kitty_mewtations
SELECT
NULL,
kitties.id,
kitty->\"$.enhanced_cattributes[{$x}].kittyId\",
kitty->\"$.enhanced_cattributes[{$x}].type\",
kitty->\"$.enhanced_cattributes[{$x}].position\",
kitty->\"$.enhanced_cattributes[{$x}].description\"
from
kitties
where kitty->\"$.enhanced_cattributes[{$x}].position\" > 0 AND kitty->\"$.enhanced_cattributes[{$x}].position\" <= 500;");
}