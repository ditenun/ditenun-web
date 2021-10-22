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
It









s hard to make a point
When youre living so loud -- vulfpeck
*/

$app->get('/status', function () use ($app) {
  return response()->json(array('success' => true,
    'message'=>'The API is up ' . $app->version()),
    200);
});


//route terbaru yang dipakai
//Original Image
$app->get('originalImage/getAll', 'OriginalImageController@getAllImage');
$app->post('originalImage', 'OriginalImageController@insertImage');
$app->get('originalImage/getById/{idJenisUlos}', 'OriginalImageController@getAllImagebyJenisUlos');
$app->post('transparant', 'TransparantImagesKristikController@createTransparantImage');

// Menyimpan hasil kristik
$app->post('saveKristik', 'TransparantImagesKristikController2@saveKristik');

// Melakukan proses kristik dari unggah pengguna
$app->post('kristik', 'KristikDigitalController3@kristiksRemoveGrid');

// Melakukan proses kristik dari gallery dan disimpan ke database
$app->post('kristik4', 'KristikDigitalController4@kristiksRemoveGrid');


// Gambar yang transparant
$app->get('transparant/{idImage}','TransparantImagesKristikController@getImagebyId');
$app->get('transparant/list/all','TransparantImagesKristikController@getAllTransparant');


$app->post('transparantGallery', 'TransparantImagesKristikController2@createTransparantImage');

//Mengambil gambar hasil generate kristik yang sudah dilakukan transparansi
$app->get('resultKristik/{id_original}/{warna}/{motif}/{benang}', 'TransparantImagesKristikController2@viewKristikTransparant');

// Menyimpan gambar ke gallery
$app->post('motifGallery', 'ImageGeneratorController3@motif');

// Generate Motif unggah dari pengguna
$app->post('motif', 'ImageGeneratorController2@motif');

// Hasil generate motif
$app->get('resultMotif/{idTransparant}', 'ImageGeneratorController3@viewMotifbyId');

// Menyimpan gambar motif
$app->post('saveMotif', 'ImageGeneratorController3@saveMotif');

// Generate Motif dan Kristik di mobile
$app->post('kristiks', 'KristikDigitalController@kristiks');
$app->post('motif-mobile', 'ImageGeneratorController@motif');


$app->get('{path:.*}', 'CustomController@stuff');

