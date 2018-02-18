<?php


namespace Kitty\Consumers;


interface ConsumerInterface
{
    public function __invoke(array $args);

    public function getRoutingKey();
}