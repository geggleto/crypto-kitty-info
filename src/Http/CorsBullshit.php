<?php


namespace Kitty\Http;


use Slim\Http\Request;
use Slim\Http\Response;

class CorsBullshit
{
    public function __invoke(Request $request, Response $response)
    {
        return $response->withHeader('Access-Control-Allow-Origin', '*')
                        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    }
}