<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*
Its hard to make a point
When youre living so loud -- vulfpeck
*/

$app->get('/status', function () use ($app) {
  return response()->json(array('success' => true,
    'message'=>'The API is up ' . $app->version()),
    200);
});

//route for img generate
$app->post('generateImg', 'ImageGeneratorController@generateImg');
$app->post('generateImg2', 'ImageGeneratorController@generateImg2');
$app->post('generateImg3', 'ImageGeneratorController@generateImg3');
//route for tenun
$app->post('tenun', 'TenunItemController@createNewTenunItem');
$app->get('tenun', 'TenunItemController@getListTenun');
$app->get('tenun/{id}', 'TenunItemController@view');

//route for motif_tenun
$app->post('motifTenun', 'MotifItemController@createNewMotifItem');
$app->get('motifTenun', 'MotifItemController@getListMotif');
$app->get('motifTenun/{id}', 'MotifItemController@view');

//route for algoritma
$app->get('algoritma', 'AlgoritmaController@getListAlgoritma');
$app->get('algoritmaParameter', 'AlgoritmaController@getListAlgoritmaParameter');
$app->get('algoritmaWithParameter', 'AlgoritmaController@getListAlgoritmaWithParameter');

$app->get('{path:.*}', 'CustomController@stuff');
