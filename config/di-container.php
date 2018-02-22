<?php

use GuzzleHttp\Client;
use Interop\Container\ContainerInterface;
use Monolog\Logger;
use Slim\Views\Twig;

$dotenv = new Dotenv\Dotenv(__DIR__.'/../');
$dotenv->load();

return [
    'settings.displayErrorDetails' => true,
    Client::class => function (ContainerInterface $container) {
        return new Client();
    },
    PDO::class => function (ContainerInterface $container) {
        return new PDO('mysql:host='.getenv('MYSQL_HOST').';dbname='.getenv('MYSQL_DATABASE'), getenv('MYSQL_USERNAME'), getenv('MYSQL_PASSWORD'));
    },
    Logger::class => function (ContainerInterface $container) {
        $log = new Monolog\Logger('crypto');

        $log->pushHandler(new \Monolog\Handler\RotatingFileHandler(__DIR__ . '/../logs/logs.log', 3, Logger::WARNING));

        return $log;
    },
    Twig::class => function ($c) {
        $view = new \Slim\Views\Twig(__DIR__.'/../templates', [
            'cache' => false
        ]);

        // Instantiate and add Slim specific extension
        $basePath = rtrim(str_ireplace('index.php', '', $c->get('request')->getUri()->getBasePath()), '/');
        $view->addExtension(new \Slim\Views\TwigExtension($c->get('router'), $basePath));

        return $view;
    }
];
