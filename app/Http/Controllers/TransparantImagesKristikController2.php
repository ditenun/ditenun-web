<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
ini_set('memory_limit', '1024M'); // or you could use 1G
use Illuminate\Support\Facades\Storage;
use App\Models\TransparantImageKristik2;
use App\Models\Benang;
use App\Models\Motif;
use App\Models\Warna;
use App\Models\OriginalImage;


class TransparantImagesKristikController2 extends Controller {
  const MODEL = "App\Models\TransparantImageKristik2";
  const TRANSPARANT_MODEL = "App\Models\UsersTransparantImage";
  const KRISTIK = "App\Models\KristikModel";
  private $limit_per_page = 9;

  use RESTActions;

  public function __construct()
  {
      $stack = HandlerStack::create();
      // my middleware
      $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
          $contentsRequest = (string) $request->getBody();

          Log::info($contentsRequest);

          return $request;
      }));

      $this->client = new Client([
          'timeout'  => 1500,
          'verify' => false,
          'allow_redirects' => true,
          'debug' => fopen('php://stderr', 'w'),
          'cookie' => true,
          'stream' => true,
          'read_timeout' => 3000,
          // 'handler' => $stack
      ]);
  }


  private function validateParam(Request $request){
      $benang = 'Benang';
      $warna = 'Warna';
      $motif = 'Motif';
      $id_original = 'id Original Image';
      $fileName = 'File Name';
      $msg = '';

      $validateId = OriginalImage::where('id',$request->input('id_original'))->value('id');

      $validateBenang = Benang::where('id',$request->input('benang'))->value('type_benang');
      $validateWarna = Warna::where('id',$request->input('warna'))->value('type_color');
      $validateMotif = Motif::where('id',$request->input('motif'))->value('type_motif');
      $kristik = self::KRISTIK;
      $fileName = $kristik::where('id',$request->input('id_kristik'))->value('file_path');

      if (empty($validateId)) {
        // code...
        $msg = ''.$id_original;
      }
      if (empty($validateBenang)) {
        // code...
        $msg = ''.$benang;
      }

      if (empty($validateWarna)) {
        // code...
        $msg = ''.$warna;
      }

      if (empty($validateMotif)) {
        // code...
        $msg = ''.$motif;
      }
      if (empty($fileName)) {
        // code...
        $msg = ''.$id_original;
      }
      return $msg;
  }


  //Function get list colors from Image

  function getColor($im)
  {
      $temp = array();
      $colors = array();
      for ($y=0;$y<imagesy($im);$y++) {
          for ($x=0;$x<imagesx($im);$x++) {
              $rgb = imagecolorat($im, $x, $y);
              if($this->check_transparent($rgb) == false) {
                  array_push($colors, $rgb);
              }
          }
      }
      return $colors;
  }


  function check_transparent($rgba)
  {

    if(($rgba & 0x7F000000) >> 24) {
        return true;
    }
    return false;
}


  public function checkGreenImage($im)
  {

    $width = imagesx($im); // Get the width of the image
    $height = imagesy($im); // Get the height of the image

    // We run the image pixel by pixel and as soon as we find a transparent pixel we stop and return true.
    for($i = 0; $i < $width; $i++) {
        for($j = 0; $j < $height; $j++) {
            $rgb = imagecolorat($im, $i, $j);
            if($this->findDistance(3735059, $rgb)<60) {
               return true;
            }
        }
    }

    // If we dont find any pixel the function will return false.
    return false;
  }

  //Find distance between 2 colours using KNN
  public function findDistance($rgbSource, $rgb2)
  {

      $r   = ($rgbSource >> 16) & 0xFF;
      $g   = ($rgbSource >> 8)  & 0xFF;
      $b   = $rgbSource & 0xFF;

      // Divide source rgb2 become to r,g, and b
      $r2   = ($rgb2 >> 16) & 0xFF;
      $g2   = ($rgb2 >> 8)  & 0xFF;
      $b2   = $rgb2 & 0xFF;

      // Using KNN to count distance between 2 RGB
      $distance = sqrt(pow($r - $r2, 2) + pow($g - $g2, 2) + pow($b - $b2, 2));
      return $distance;
  }


  // Fill color to background Transparantfunction imageTransparant()
  public function imageTransparant($background, $im, $square,$keyColors, $newColors,$id_original,$benang,$warna,$motif)
  {

    //	var_dump($keyColors);

      $model = self::MODEL;
      $resultResponse = array();

      // Save Original Image
      $uploadFileName = str_random(10).'.'.'png';
      // Show the transparans Image
      header('Content-type: image/png');
      $fileResultPath = 'storage/app/kristik/transparansi_kristik/'.$uploadFileName;
      imagepng($im,$fileResultPath);

      //  Insert image to database modelGenerate
       $generate = $model::create([
         "id_original_image" => $id_original,
         "name_image" => $uploadFileName,
         "path" => $fileResultPath,
         "benang" => $benang,
         "warna" => $warna,
         "motif" => $motif
      ]);


      $gen = response($generate);
      array_push($resultResponse,$gen);


      $source_width = imagesx($im);
      $source_height = imagesy($im);

      $background= imagecreatetruecolor($source_width, $source_height);
      imagesavealpha($background, true);
      $color = imagecolorallocatealpha($background, 0, 0, 0, 127);
      imagefill($background, 0, 0, $color);

      foreach ($keyColors as $key) {

          for ($y=0;$y<imagesy($background);$y++) {
              for ($x=0;$x<imagesx($background);$x++) {
                  //Find color RGB in image
                  $rgb = imagecolorat($im, $x, $y);
                  $r   = ($rgb >> 16) & 0xFF;
                  $g   = ($rgb >> 8)  & 0xFF;
                  $b   = $rgb & 0xFF;

                  $fillColor = imagecolorallocate($im, $r, $g, $b);
                  // var_dump(findDistance(16711680,$rgb));

                  if (($this->findDistance($newColors[$key], $rgb) > 80) && ($this->check_transparent($rgb) == false))
                  {
                    //var_dump(findDistance($newColors[$key], $rgb));
                    imagefilledrectangle($square, 15, 15, 0, 0, $fillColor);
                    imagecopyresampled($background, $square, $x, $y, 0, 0, 1, 1, 1, 1);
                }
              }
          }

          $uploadFileName = str_random(10).'.'.'png';
          $fileResultPath = 'storage/app/kristik/transparansi_kristik/'.$uploadFileName;
          // Save the transparan Image
          header('Content-type: image/png');
          imagepng($background,$fileResultPath);

          $generate = $model::create([
              "id_original_image" => $id_original,
              "name_image" => $uploadFileName,
              "path" => $fileResultPath,
              "benang" => $benang,
              "warna" => $warna,
              "motif" => $motif
          ]);

          $gen = response($generate);
          array_push($resultResponse,$gen);



          $source_width = imagesx($im);
          $source_height = imagesy($im);

          $background= imagecreatetruecolor($source_width, $source_height);
          imagesavealpha($background, true);
          $color = imagecolorallocatealpha($background, 0, 0, 0, 127);
          imagefill($background, 0, 0, $color);
      }
      imagedestroy($background);
      $Response = array('data' => $resultResponse);
      return $Response;
  }


    function originalTransparant($background, $im, $square)
    {
      for ($y=0;$y<imagesy($background);$y++) {
          for ($x=0;$x<imagesx($background);$x++) {
              //Find color RGB in image
              $rgb = imagecolorat($im, $x, $y);
              $r   = ($rgb >> 16) & 0xFF;
              $g   = ($rgb >> 8)  & 0xFF;
              $b   = $rgb & 0xFF;

              $fillColor = imagecolorallocate($im, $r, $g, $b);

              if ($this->findDistance(3735059, $rgb)>180 && $this->check_transparent($rgb) == false) {
                  imagefilledrectangle($square, 15, 15, 0, 0, $fillColor);
                  imagecopyresampled($background, $square, $x, $y, 0, 0, 1, 1, 1, 1);
              }
          }
      }
      return $background;
  }



  function getRGB($rgb)
  {
      foreach ($rgb as $value) {
          $r   = ($value >> 16) & 0xFF;
          $g   = ($value >> 8)  & 0xFF;
          $b   = $value & 0xFF;
          var_dump($r, $g, $b, "");
      }
  }


  // Melakukan pengurangan warna dan menyatukannya berdasarkan distance
  function reduceColor($arrayColor){
      sort($arrayColor);
      $clength = count($arrayColor);
      $diff = $arrayColor[0];
      $newColors = array();
      for ($x = 0; $x < $clength;$x++){
          if ($this->findDistance($diff, $arrayColor[$x])==0) {
              # code...
              array_push($newColors,$diff);
          }
          elseif ($this->findDistance($diff, $arrayColor[$x])<85) {
              # code...
              array_push($newColors, $diff);
              // $diff = $arrayColor[$x];
          }else{
              array_push($newColors, $arrayColor[$x]);
              $diff = $arrayColor[$x];
          }

      }
      return $this->checkMultipleValue($newColors);
  }

  // Melakukan pengecekan apabila ada kode warna yang berulang
  function checkMultipleValue($arrayColor){
      $value = $arrayColor[0];
      $clength = count($arrayColor);
      $colors = array();
      $keys = array();
      $count = 0;
      $newColors = array();
      // array_push($colors,$arrayColor[0]);

      for($x = 0 ; $x < $clength;$x++){
          if ($value != $arrayColor[$x]) {
              # code...
              array_push($colors,$value);
              array_push($keys,$count);
              $count = 0;
              $value = $arrayColor[$x];
          }elseif ($x == $clength-1) {
              # code...
              array_push($colors,$value);
              array_push($keys,$count);
              // var_dump($x,$clength);
          }
          $count = $count + 1;
      }
      $newColors = (array_combine($keys, $colors));
      ksort($newColors);
      return $newColors;
  }


  function createTransparantImage(Request $req){
    $msg = $this->validateParam($req);
    if($msg != ''){
        return response()->json(array('success' => false,
          'message'=>'Get item failed, no item found',
          'data' => $msg.' not found'),
          404);
    }

    else {
      // code...
      $id_original=$req->get ('id_original');
      $benang=$req->get ('benang');
      $warna=$req->get ('warna');
      $motif=$req->get ('motif');
      // $name_image = $req->get ('name_image');

      $kristik = self::KRISTIK;
      $fileName = $kristik::where('id',$req->input('id_kristik'))->value('file_path');

      if(empty($fileName))
      return response()->json(array('success' => false,
        'message'=>'Get item failed, no item found',
        'data' => $fileName),
        404);

      $im = imagecreatefromstring(file_get_contents($fileName));
      $filePath = base_path('public/img_src/square.png');
      $square = imagecreatefrompng($filePath);

      //Make a background Transparant
      $source_width = imagesx($im);
      $source_height = imagesy($im);

      $background= imagecreatetruecolor($source_width, $source_height);
      imagesavealpha($background, true);
      $color = imagecolorallocatealpha($background, 0, 0, 0, 127);
      imagefill($background, 0, 0, $color);

        if ($this->checkGreenImage($im)==true) {
          # code...
          $im =$this->originalTransparant($background, $im, $square);
          // var_dump("hasil");
      }

      //$im =$this->originalTransparant($background, $im, $square);

      $colors = $this->getColor($im);
      $newColors = $this->reduceColor($colors);
      $keyColors = array_keys($newColors);

      $twoKeys = array();
      $klength = count($keyColors);
      if ($klength>=2) {
          # code...
          array_push($twoKeys,$keyColors[$klength-1]);
          array_push($twoKeys,$keyColors[$klength-2]);

          return $this->imageTransparant($background, $im, $square,$twoKeys, $newColors,$id_original,$benang,$warna,$motif);
      }else
      {

        $resultResponse = array();
        // imagepng($im, NULL, 9);

        // Save Original Image
        $uploadFileName = str_random(10).'.'.'png';
        // Show the transparans Image
        header('Content-type: image/png');
        $fileResultPath = 'storage/app/kristik/transparansi_kristik/'.$uploadFileName;
        imagepng($im,$fileResultPath);
        //
        if ($im) {
          // code...
          //  Insert image to database modelGenerate
        $generate = TransparantImageKristik2::create([
            "id_original_image" => $id_original,
            "name_image" => $uploadFileName,
            "path" => $fileResultPath,
            "benang" => $benang,
            "warna" => $warna,
            "motif" => $motif
        ]);
          $gen = response($generate);
          array_push($resultResponse,$gen);

          $Response = array('data' => $resultResponse);
          return $Response;
        }
        else {
          // code...
          return 'nothing';
        }
      }
    }


  }

  //Get Image By ID
  function getImagebyId($idImage){
       // $model = new UserMotif();
       $modelGenerate = self::MODEL;
       $motif = $modelGenerate::where('id', $idImage)->first();

       $response = [
           'data' => $motif
       ];
       return $response;
  }

  //Save image transparant
  function saveImage(Request $request){
      $modelTransparant = self::TRANSPARANT_MODEL;
      $model = self::MODEL;

      $id = $request->input('id_image');
      $data = $model::where('id', $id)->get()->first();

      if($data == null){
          $generate = NULL;
      }

     else {
          $generate = $modelTransparant::create([
              'name' => $data->name,
              'id_image' => $data->id,
              'file_path' => $data->file_path,
          ]);
     }
      $gen = response($generate);
      $Response = array('data' => $gen);
      return $Response;
  }

  function saveKristik(Request $req){
    $modelGenerate = self::MODEL;

    $image = $req->file('img_file');
    $id_original=$req->get ('id_original');
    $benang=$req->get ('benang');
    $warna=$req->get ('warna');
    $motif=$req->get ('motif');

    $uploadFileName = str_random(10).'.'.'png';
    $destinationPath = base_path('storage\app\kristik\transparansi_kristik'); // upload path
    $image->move($destinationPath, $uploadFileName);
    $fileResultPath = 'storage/app/kristik/transparansi_kristik/'.$uploadFileName;
    $generate = $modelGenerate::create([
        "id_original_image" => $id_original,
        "name_image" => $uploadFileName,
        "path" => $fileResultPath,
        "benang" => $benang,
        "warna" => $warna,
        "motif" => $motif
    ]);
      // $gen = response($generate);
      // array_push($resultResponse,$gen);
      //
      // $Response = array('data' => $resultResponse);
      return $generate;

  }

  //Get all transparant Image
  function getAllTransparant(){
      $modelGenerate = self::MODEL;

      $allMotif = $modelGenerate::orderBy('id', 'asc')
      ->paginate($this->limit_per_page);

      $response = [
          'pagination' => [
              'total' => $allMotif->total(),
              'per_page' => $allMotif->perPage(),
              'current_page' => $allMotif->currentPage(),
          ],
          'data' => $allMotif
      ];
      return response()->json($response);
  }


  public function viewKristikTransparant($id_original,$warna,$motif,$benang){
    $modelGenerate = self::MODEL;
    $allKristik = $modelGenerate::where([
       'id_original_image' => $id_original,
       'warna' => $warna,
       'motif' => $motif,
       'benang' => $benang
       ])->orderBy('id', 'asc')
       ->paginate($this->limit_per_page);

    $response = [
        'data' => $allKristik
    ];
    return response()->json($response);
  }
}
