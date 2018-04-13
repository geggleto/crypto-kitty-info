<?php

use Kitty\KittyApp;
use Kitty\Search\KittySearch;

set_time_limit(0);

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(\PDO::class);

$kittySearch = $container->get(KittySearch::class);

$query = 'select id, JSON_EXTRACT(kitty, \'$.is_fancy\') as fancy, JSON_EXTRACT(kitty, \'$.enhanced_cattributes\') as cattributes from kitties
where
id > 680000
and JSON_EXTRACT(kitty, \'$.enhanced_cattributes\') LIKE \'%springcrocus%\'
and JSON_EXTRACT(kitty, \'$.enhanced_cattributes\') LIKE \'%amur%\'
and JSON_EXTRACT(kitty, \'$.enhanced_cattributes\') LIKE \'%fabulous%\';';

$statement = $pdo->prepare($query);

$statement->execute([]);

$rows = $statement->fetchAll(PDO::FETCH_ASSOC);

$buckets = [];

foreach ($rows as $row)
{
    $cattributes = json_decode($row['cattributes'], true);

    foreach ($cattributes as $cattribute) {
        $bucket     = $cattribute['type'];
        $cattribute = $cattribute['description'];

        if (!isset($buckets[$bucket])) {
            $buckets[$bucket] = [];
        }

        if (!in_array($cattribute, $buckets[$bucket])) {
            $buckets[$bucket][] = $cattribute;
        }
    }
}

//print json_encode($buckets, JSON_PRETTY_PRINT);

$out = [];

//Need to translate buckets
foreach ($buckets as $cattributeType => $cattributes)
{
    //body
    if ($cattributeType === 'body') {
        $body = array_filter($kittySearch->getFur(), function ($row) {
            return !empty($row);
        });
        $out['body'] = array_diff($cattributes, $body);
    }
    //mouth
    if ($cattributeType === 'mouth') {
        $mouth = array_filter($kittySearch->getMouth(), function ($row) {
            return !empty($row);
        });

        $out['mouth'] = array_diff($cattributes, $mouth);
    }
    //coloreyes
    if ($cattributeType === 'coloreyes') {
        $eyeColor = array_filter($kittySearch->getEyeColor(), function ($row) {
            return !empty($row);
        });

        $out['coloreyes'] = array_diff($cattributes, $eyeColor);
    }
    //colorprimary
    if ($cattributeType === 'colorprimary') {
        $baseColor = array_filter($kittySearch->getBaseColor(), function ($row) {
            return !empty($row);
        });

        $out['colorprimary'] = array_diff($cattributes, $baseColor);
    }
    //colortertiary
    if ($cattributeType === 'colortertiary') {
        $accentColor = array_filter($kittySearch->getAccentColor(), function ($row) {
            return !empty($row);
        });

        $out['colortertiary'] = array_diff($cattributes, $accentColor);
    }
}

print json_encode($out, JSON_PRETTY_PRINT);