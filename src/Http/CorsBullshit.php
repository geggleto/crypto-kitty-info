<?php


namespace Kitty\Http;


use Slim\Http\Request;
use Slim\Http\Response;

class CorsBullshit
{
    public function __invoke(Request $request, Response $response)
    {
        return $response;
    }
}