<?php

use function DI\get;
use Kitty\WebSockets\CryptoBattle;
use React\MySQL\Connection;

include_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

$options = array(
    'host'   => getenv('MYSQL_HOST'),
    'port'   => 3306,
    'user'   => getenv('MYSQL_USERNAME'),
    'passwd' => getenv('MYSQL_PASSWORD'),
    'dbname' => getenv('MYSQL_DATABASE'),
);

$loop = React\EventLoop\Factory::create();

$connection = new Connection($loop, $options);

// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App('dna.kitty.fyi', 8080, '0.0.0.0', $loop);
$app->route('/battle', new CryptoBattle($connection), ['*']);
$app->run();