<?php


namespace Kitty\Http;


use Kitty\Security\AuthService;
use Slim\Http\Request;
use Slim\Http\Response;

class Authorization
{

    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {

        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response)
    {
        $profile = $request->getParsedBodyParam('profile');

        return $response->withJson(['isAuthorized' => $this->authService->authorize($profile)]);
    }
}