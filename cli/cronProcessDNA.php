<?php

use Kitty\KittyApp;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(PDO::class);

$statement = $pdo->prepare('update kitties set `genes_hex` = ?, `genes_bin` = ?, genes_kai = ? where id = ?');

$date = date('Ymd', strtotime('yesterday'));
$file = "/tmp/{$date}.csv";
print $file;

$fh = fopen($file, 'r');

$row = 0;
while ($line = fgetcsv($fh))
{
    if ($row == 0) {
        $row++;
        continue;
    }

    $id = $line[0];
    $genes_hex = $line[6];
    $genes_bin = $line[7];
    $genes_kai = $line[8];

    if (!$statement->execute([
        $genes_hex,
        $genes_bin,
        $genes_kai,
        $id
    ])) {
        print "Error\n\n";
        print $statement->errorInfo();
        print_r($statement->errorInfo());
    }
}