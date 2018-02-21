<?php


namespace Kitty;


use DI\Bridge\Slim\App;
use DI\ContainerBuilder;

class KittyApp extends App
{
    protected function configureContainer(ContainerBuilder $builder)
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/../');
        $dotenv->load();

        $builder->addDefinitions(__DIR__ . '/../config/di-container.php');
    }
}