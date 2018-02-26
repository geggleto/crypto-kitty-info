<?php

use Kitty\KittyApp;

set_time_limit(0);

include_once __DIR__ . '/../../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(\PDO::class);
$attributes = [];

$statement = $pdo->prepare('select JSON_EXTRACT(kitty, "$.enhanced_cattributes") as `attributes` from kitties where `id` = ? LIMIT 1');


for ($x=1; $x<560000; $x++) {

    $statement->execute([$x]);

    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if (!empty($row['attributes'])) {

        $cat_attr = array_filter(
            json_decode($row['attributes'], true),
            function ($cattribute) {
                return ($cattribute['position'] == 1);
            }
        );

        $attributes[count($cat_attr)]++;
        if (count($cat_attr) > 5) {
            print "Kitty Id {$x} \n";
        }
    }
}

asort($attributes);

print "Number of Diamonds | Number of Kitties \n";
print "------------------|-------------------\n";

foreach ($attributes as $name => $count) {
    if ($name === 0) {
        continue;
    }
    print "$name | $count \n";
}