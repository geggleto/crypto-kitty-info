<?php
use Kitty\KittyApp;

set_time_limit(0);

include_once __DIR__ . '/../../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(\PDO::class);

$statement = $pdo->prepare('select * from dna_stats');
$statement->execute();

$queryStatement = $pdo->prepare('select
min(id) as `min`,
max(id) as `max`
FROM kitties
where gen=0 and substr(genes_kai, ?,1) = ?
and JSON_TYPE(JSON_EXTRACT(kitty, "$.created_at")) != "NULL" and JSON_LENGTH(kitty, "$.enhanced_cattributes") > 0;');


$updateStatement = $pdo->prepare('update dna_stats set `first` = ?, `last` = ? where `position` = ? and `letter` = ? LIMIT 1');

foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $result) {
//    var_dump($result);

    $position   = $result['position'];
    $letter     = $result['letter'];

    $queryStatement->execute([$position, $letter]);

    $queryResult = $queryStatement->fetch(PDO::FETCH_ASSOC);

//	var_dump($queryResult);

    $updateStatement->execute([$queryResult['min'], $queryResult['max'], $position, $letter]);
}

print "\nDone!!!\n";

