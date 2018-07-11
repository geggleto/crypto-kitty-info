<?php

use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

/** @var $kittyService KittyService */
$kittyService = $container->get(KittyService::class);

$contractMax = $kittyService->getMaximumKittyFromContract();

$dbAt = $kittyService->getMaxInDb();

$pdo = $container->get(PDO::class);

$statement = $pdo->prepare('select id from kitties where id = ?');

print "Checking Kitties\n";
for ($x=1; $x<=$contractMax; $x++) {

    $statement->execute([$x]);

    if ($statement->rowCount() === 0) {
        $result = $kittyService->insertKitty($x);
        $attempts = 0;
        while ($result === false && $attempts < 5) {
            $result = $kittyService->insertKitty($x);
            $attempts++;
        }

        if (!$result) {
            print "$x\n";
        }
    }
}
