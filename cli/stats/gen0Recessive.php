<?php

use Kitty\KittyApp;

set_time_limit(0);

include_once __DIR__ . '/../../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$pdo = $container->get(\PDO::class);
$attributes = [];

$statement = $pdo->prepare('select
JSON_EXTRACT(kitty, "$.enhanced_cattributes") as `cattributes`
from
kitties where gen=0 and JSON_TYPE(JSON_EXTRACT(kitty, "$.created_at")) != "NULL" and JSON_LENGTH(kitty, "$.enhanced_cattributes") > 0
ORDER BY id
LIMIT 1000;');

$statement->execute();

$traits = [];

print "Processing\n";

while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $decoded = json_decode($row['cattributes'], true);

    foreach ($decoded as $item => $value) {
        $cattrib = $value['description'];

        if (!isset($traits[$cattrib])) {
            $traits[$cattrib] = 1;
        } else {
            $traits[$cattrib]++;
        }
    }
}

print "Done\n";
print "Cattribute \t\t Count \n";
foreach ($traits as $trait => $count) {
    print "$trait \t\t $count \n";
}



