<?php

use Kitty\KittyApp;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(PDO::class);

$statement = $pdo->prepare('update kitties set `gene_hex` = ?, `gene_bin` = ?, gene_kai = ? where id = ?');

$date = date('Ymd', strtotime('yesterday'));
$file = "/tmp/{$date}.csv";
print $file;

$fh = fopen($file, 'r');

while ($line = fgetcsv($fh))
{
    $id = $line[0];
    $genes_hex = $line[6];
    $genes_bin = $line[7];
    $genes_kai = $line[8];

    $statement->execute([
        $genes_hex,
        $genes_bin,
        $genes_kai,
        $id
    ]);
}