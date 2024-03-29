<?php

use Kitty\Http\Authorization;
use Kitty\Http\CkApi;
use Kitty\Http\CorsBullshit;
use Kitty\Http\KittySaleEvent;
use Kitty\Http\ProfileController;
use Kitty\Http\SearchDnaController;
use Kitty\KittyApp;
use Kitty\Search\CattributeMarketResearch;
use Kitty\Search\MewtationSearch;
use Slim\Http\Request;
use Slim\Http\Response;

include_once __DIR__ . '/../vendor/autoload.php';

$app = new KittyApp();

$app->post('/insert/sale', KittySaleEvent::class);
$app->post('/insert/sales', [KittySaleEvent::class, 'bulkImport']);
$app->post('/insert/blockNumber', [ KittySaleEvent::class, 'getLastBlock' ]);

//Fucking CORS
$app->options('{name:.+}', CorsBullshit::class);

//New Route for UI
$app->post('/fetch/dna', [ProfileController::class, 'fetchDnaForKitties']);
//Old Route but used in UI
$app->get('/dna/profile/{profile}/csv', [ProfileController::class, 'exportToCsv']);

//Search Things
//$app->get('/v2/search', SearchController::class);
//$app->get('/search', SearchDnaController::class);
$app->post('/{profile}/search', [SearchDnaController::class, 'query']);

$app->post('/authorizations', Authorization::class);

$app->post('/search/mewtation', MewtationSearch::class);

$app->get('/cattribute/prices', CattributeMarketResearch::class);

$app->get('/cattribute/prices/{cattribute}', [CattributeMarketResearch::class, 'findCattributePrices']);

$app->get('/dna/search', [SearchDnaController::class, 'getSearchArray']);

$app->get('/stats/ck/api', CkApi::class);

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
