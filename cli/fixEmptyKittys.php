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

$statement = $pdo->prepare("select id from kitties where kitty LIKE ? order by id;");
$statement->execute(['%created_at":null%']);

$removeStatment = $pdo->prepare('delete from kitties where id = ?');

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];

    $removeStatment->execute([$id]);

    $kittyService->insertKitty($id);

}