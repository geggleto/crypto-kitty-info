<?php

use Kitty\KittyApp;

set_time_limit(0);

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(\PDO::class);

$query = 'select id, JSON_EXTRACT(kitty, \'$.is_fancy\') as `fancy`, JSON_EXTRACT(kitty, \'$.enhanced_cattributes\') as `cattributes` from kitties
where
id > 680000
and kitty LIKE \'%springcrocus%\'
and kitty LIKE \'%amur%\'
and kitty LIKE \'%fabulous%\';';

$statement = $pdo->prepare($query);

$statement->execute([]);

$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$buckets = [];

foreach ($rows as $row)
{
    $bucket = $row['type'];
    $cattribute = $row['description'];

    if (!isset($buckets[$bucket])) {
        $buckets[$bucket] = [];
    }

    if (!in_array($cattribute, $buckets[$bucket])) {
        $buckets[$bucket][] = $cattribute;
    }
}

print json_encode($buckets, JSON_PRETTY_PRINT);