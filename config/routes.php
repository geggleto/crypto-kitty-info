<?php

use Kitty\Http\ProfileController;
use Kitty\Http\Search\AuthenticateUser;
use Kitty\Http\Search\RegisterUser;
use Kitty\Http\Search\SearchController;

use Kitty\Http\SearchDnaController;
use Kitty\Http\StaticController;

$app->get('/', [StaticController::class, 'showIndexPage']);

$app->get('/profile', [StaticController::class, 'showProfilePage']);
$app->get('/dna/profile/{profile}', ProfileController::class);
$app->get('/dna/profile/{profile}/csv', [ProfileController::class, 'exportToCsv']);


$app->get('/register', [StaticController::class, 'showRegisterPage']);
$app->get('/login', [StaticController::class, 'showLoginPage']);

$app->post('/login',  AuthenticateUser::class);
$app->post('/register', RegisterUser::class);

$app->group('', function () {
    $this->post('/v2/search', SearchDnaController::class);
    $this->get('/v2/search', [StaticController::class, 'showKittySearch']);
}); //->add(SecurityMiddleware::class);