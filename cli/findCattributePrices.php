<?php

set_time_limit(0);

use GuzzleHttp\Client;
use Kitty\KittyApp;
use Kitty\Services\KittyService;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$container = $app->getContainer();

$genMax = 5;

$pdo = $container->get(PDO::class);

//$pdo->query('truncate table `kitty_attribute_prices`');

$statement = $pdo->prepare('insert into `kitty_attribute_prices` (generation, cattribute,price,`date`) VALUES(?,?,?,?)');

$cattributes = json_decode(file_get_contents('https://api.cryptokitties.co/cattributes'), true);

foreach ($cattributes as $cattribute) {
    $attribute = $cattribute['description'];
    print "Processing {$attribute}\n";
    if ($attribute !== 'totesbasic') {

        for ($gen = 0; $gen <= 5; $gen++) {
            $result = json_decode(file_get_contents('https://api.cryptokitties.co/v2/kitties?offset=0&limit=12&search=sphynx+gen:1&parents=false&authenticated=true&include=sale&orderBy=current_price&orderDirection=asc'), true);

            $price = (int)substr($result['kitties'][0]['auction']['current_price'], 0, 6) / 10 ** 7;

            $statement->execute([
                $gen,
                $attribute,
                $price,
                date("Y-m-d")
            ]);
        }
    }
}

print "Done\n";