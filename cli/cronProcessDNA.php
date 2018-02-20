<?php

use Kitty\KittyApp;
use Kitty\Services\KittyService;

set_time_limit(0);

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(PDO::class);

$statement = $pdo->query('select id from kitties where genes_kai IS null');

$updateStatement = $pdo->prepare('update kitties set genes_hex = ?, genes_bin = ?, genes_kai =? where id = ?');

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];

    $dna = KittyService::getDnaFromContract($id);

    $updateStatement->execute([ $dna['hex'], $dna['bin'], $dna['kai'], $id]);
}