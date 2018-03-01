<?php

use Kitty\WebSockets\CryptoBattle;

include_once __DIR__ . '/../vendor/autoload.php';

// Run the server application through the WebSocket protocol on port 8080
$app = new Ratchet\App('localhost', 8090);
$app->route('/battle', new CryptoBattle());
$app->run();