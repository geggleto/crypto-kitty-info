<?php

use Kitty\Http\BattleZone\BattlePage;
use Kitty\Http\BattleZone\Profile;
use Kitty\Http\CorsBullshit;
use Kitty\Http\DnaController;
use Kitty\Http\GetCattributesForKitty;
use Kitty\Http\HomePage;
use Kitty\Http\MyProfile;
use Kitty\Http\ProfileController;
use Kitty\Http\Search\SearchController;
use Kitty\Http\SearchDnaController;
use Kitty\Http\SearchPage;
use Kitty\KittyApp;
use Slim\Http\Request;
use Slim\Http\Response;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

//$app->get('/dna/body/{code}', [DnaController::class, 'searchBody']);
//$app->get('/dna/body/color/{code}', [DnaController::class, 'searchBodyColor']);
//
//$app->get('/dna/pattern/{code}', [DnaController::class, 'searchPattern']);
//$app->get('/dna/pattern/color/{code}', [DnaController::class, 'searchPatternColor']);
//$app->get('/dna/eye/color/{code}', [DnaController::class, 'searchEyeColor']);
//$app->get('/dna/eye/type/{code}', [DnaController::class, 'searchEyeType']);
//
//$app->get('/dna/secondary/color/{code}', [DnaController::class, 'searchSecondaryColor']);
//
//$app->get('/dna/wild/{code}', [DnaController::class, 'searchWild']);
//
//$app->get('/dna/mouth/{code}', [DnaController::class, 'searchMouth']);
//
//$app->get('/dna/kitty/{kittenId}', [DnaController::class, 'searchForKitten']);
//$app->get('/dna/kitty/{kittenId}/pretty', [DnaController::class, 'searchForKittenPretty']);

//$app->get('/dna/profile/{profile}', ProfileController::class);

//Old Routes
$app->get('/profile', function (Request $request, Response $response) {
    return $response->withRedirect('http://cryptokittydata.info');
});

$app->get('/', function (Request $request, Response $response) {
    return $response->withRedirect('http://cryptokittydata.info');
});




//Fucking CORS
$app->options('{name:.+}', CorsBullshit::class);

//New Route for UI
$app->post('/fetch/dna', [ProfileController::class, 'fetchDnaForKitties']);
//Old Route but used in UI
$app->get('/dna/profile/{profile}/csv', [ProfileController::class, 'exportToCsv']);

//Search Things
$app->get('/v2/search', SearchController::class);
$app->get('/search', SearchDnaController::class);
$app->post('/search', [SearchDnaController::class, 'query']);



$app->add(function (Request $req, Response $res, $next) {
    /** @var  $response Response */
    $response = $next($req, $res);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');

//->withHeader('Access-Control-Allow-Origin', substr($req->getServerParam('HTTP_REFERER'),0, -1))

});


$app->run();
