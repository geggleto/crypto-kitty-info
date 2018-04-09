<?php

use Kitty\KittyApp;

set_time_limit(0);

include_once __DIR__ . '/../../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(\PDO::class);


$statement = $pdo->prepare('select
substr(genes_kai, ?,1) as letter,
count(*) as `count`
from kitties
where gen=0 and substr(genes_kai, ?,1) IS NOT NULL and substr(genes_kai, ?,1) != \'\' and JSON_TYPE(JSON_E$
group by letter;');

$insertStatement = $pdo->prepare('insert into `dna_stats` VALUES(?,?,?,?,?)');
for ($x = 1; $x <= 48; $x++) {
    $statement->execute([$x, $x, $x]);

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);


    foreach ($results as $result) {
        $insertStatement->execute([$x, $result['letter'], $result['count'], 0, 0]);
    }
}

print "\nDone!!!\n";