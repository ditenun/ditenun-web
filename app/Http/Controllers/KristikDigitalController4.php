<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MotifTenun;
use Illuminate\Support\Facades\Storage;
use App\Models\KristikModel as KristikModel;
//header("Content-type: image/jpeg");

class KristikDigitalController4 extends Controller{

  // current max dimen 141 => 19881
  const MAX_SIZE = 7000000;//7918596;
  const CROSS_STITCH = 20;
  const ORIGINALIMAGE = "App\Models\OriginalImage";
  public function __construct()
  {
  }

  private function validateParam(Request $request){
    // $square_size = 'square_size';
    $crosstichSize = 'cross_stitch_size';
    $color_amount = 'color_amount';
    $img_file = 'img_file';
    $msg = '';
    $min_dimen = self::MAX_SIZE;

    if($request->input($crosstichSize) == null){
      if($msg=='')
        $msg .= $crosstichSize;
      else $msg .= ', '.$crosstichSize;
    }

    if($request->input($color_amount) == null || strval($request->input($color_amount)) !== strval(intval($request->input($color_amount))) || intval($request->input($color_amount)) <= 1){
      if($msg=='')
        $msg .= $color_amount;
      else $msg .= ', '.$color_amount;
    }
    return $msg;
  }

  private function setMemoryForImage( $filename ){
      $imageInfo = getimagesize($filename);
      $MB = 1048576;  // number of bytes in 1M
      $K64 = 65536;    // number of bytes in 64K
      $TWEAKFACTOR = 1.5;  // Or whatever works for you
      $memoryNeeded = round( ( $imageInfo[0] * $imageInfo[1]
                                             * $imageInfo['bits']
                                             * (isset($imageInfo['channels'])?$imageInfo['channels']/8:1)
                               + $K64
                             ) * $TWEAKFACTOR
                           );
      //ini_get('memory_limit') only works if compiled with "--enable-memory-limit" also
      //Default memory limit is 8MB so well stick with that.
      //To find out what yours is, view your php.ini file.
      $memoryLimit = 128 * $MB;
      // if (function_exists('memory_get_usage') &&
      //     memory_get_usage() + $memoryNeeded > $memoryLimit)
      // {
          $newLimit = ceil( ( memory_get_usage()
                                              + $memoryNeeded
                                              ) / $MB
                                          );

          //ini_set( 'memory_limit', $newLimit . 'M' );
          return $newLimit;
      // }else{
      //     return 0;
      // }
  }

  private function optimizeResolution(&$source_width, &$source_height, $squareSize){
    $temp_width = $source_width;
    $temp_height = $source_height;
    $cur_run_mem = round(($source_width/$squareSize)*self::CROSS_STITCH)*(($source_height/$squareSize)*self::CROSS_STITCH);
    $new_run_mem = $source_width*$source_height;
    $max_dimen = round(sqrt(self::MAX_SIZE/pow(self::CROSS_STITCH,2)));
    if($source_width >= $source_height && ($cur_run_mem > self::MAX_SIZE || $new_run_mem > self::MAX_SIZE)){
      $source_width = $max_dimen;
      $source_height = round($temp_height/$temp_width * $source_width);
    }else if($source_width < $source_height && ($cur_run_mem > self::MAX_SIZE || $new_run_mem > self::MAX_SIZE)){
      $source_height = $max_dimen;
      $source_width = round($temp_width/$temp_height * $source_height);
    }
  }

  private function sharedFunctionWeb(Request $request){
    ini_set('max_execution_time', 1500);
    // get param request
    // $squareSize = $request->input('square_size');
    $squareSize = 1;
    $colorsAmount = $request->input('color_amount');
    $crosstich = $request->input('cross_stitch_size');
    $crosstichSize = $crosstich;




    $kristik = self::ORIGINALIMAGE;
    $fileName = $kristik::where('id',$request->input('id_original'))->value('path');

    $imagedata = file_get_contents($fileName);
    $base64 = base64_encode($imagedata);
    $data = base64_decode($base64);
    $source = imagecreatefromstring($data);

    $nama_file = str_random(10);//$image->getClientOriginalName();
    $nama_file_save = $nama_file.'.'.'png';

    // get image size, create new size based on squareSize param
    $source_width = imagesx($source);
    $source_height = imagesy($source);
    $this->optimizeResolution($source_width, $source_height, $squareSize);

    $newWidth = $crosstichSize;
    // $newHeight = $crosstichSize;
    $newHeight = ($source_height*($crosstich/$source_width));

    $squaresWidth = $crosstichSize;
    // $squaresHeight = $crosstichSize;
    $squaresHeight = ($source_height*($crosstich/$source_width));

    $source_width = imagesx($source);
    $source_height = imagesy($source);

    // creating scaled copy of input image, truecolor = 24 bits per pixel
    $sourceResized = imagecreatetruecolor($newWidth, $newHeight);
    // making white background for images with transparency
    $whiteBackground = imagecolorallocate($sourceResized, 57, 255, 20);
    //$whiteBackground = imagecolorallocate($sourceResized, 255, 255, 255);
    imagefill($sourceResized, 0, 0, $whiteBackground);
    imagecopyresampled($sourceResized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $source_width, $source_height);
    imagedestroy($source); // release memory

    $checkeredInput = imagecreatetruecolor($newWidth, $newHeight);
    for($row = 0; $row<$squaresHeight; $row++) {
    for($col = 0; $col<$squaresWidth; $col++) {
      $square = @imagecreatetruecolor($squareSize, $squareSize);
      imagecopyresized($square, $sourceResized, 0, 0, $col * $squareSize, $row * $squareSize, $squareSize, $squareSize, $squareSize, $squareSize);

      $scaled = @imagecreatetruecolor(1,1);
      imagecopyresampled($scaled, $square, 0, 0, 0, 0, 1, 1, $squareSize, $squareSize);
      $meanColor = imagecolorat($scaled, 0, 0);
      imagedestroy($scaled);

      //filling checkeredInput
      $square = @imagecreatetruecolor($squareSize, $squareSize);
      imagefill($square, 0, 0, $meanColor);
      imagecopymerge($checkeredInput, $square, $col * $squareSize, $row * $squareSize, 0, 0, $squareSize, $squareSize, 60);

      imagedestroy($square);
    }
  }

  ImageTrueColorToPalette($checkeredInput, false, $colorsAmount);
  ImageColorMatch($sourceResized, $checkeredInput);//improving colors

  imagedestroy($sourceResized);


  //creating colors array
  $colors = array();
  for($row = 0; $row<$squaresHeight; $row++) {
    for($col = 0; $col<$squaresWidth; $col++) {
      $square = @imagecreatetruecolor($squareSize, $squareSize);
      imagecopyresized($square, $checkeredInput, 0, 0, $col * $squareSize, $row * $squareSize, $squareSize, $squareSize, $squareSize, $squareSize);
      $colors[] = imagecolorat($square, 0, 0);

      imagedestroy($square);
    }
  }

  imagedestroy($checkeredInput);
    return [
      'squaresWidth' => $squaresWidth,
      'squaresHeight' => $squaresHeight,
      'colors' => $colors,
      'nama_file_save' => $nama_file_save
    ];
  }
  public function kristiksRemoveGrid(Request $request) {
    $model = new KristikModel();

    $msg = $this->validateParam($request);
    if($msg != ''){
      return response()->json(array(
        'message'=>$msg.' is not valid'
      ), 200);
    }
    $res = $this->sharedFunctionWeb($request);
    $squaresWidth = $res['squaresWidth'];
    $squaresHeight = $res['squaresHeight'];
    $colors = $res['colors'];
    $nama_file_save = $res['nama_file_save'];

    //simulation of cross-stich
    $simulationSquare = 1;
    $simulation = imagecreatetruecolor($squaresWidth*$simulationSquare, $squaresHeight*$simulationSquare);
    $i=0;
    for($row = 0; $row<$squaresHeight; $row++) {
      for($col = 0; $col<$squaresWidth; $col++) {
        $r = ($colors[$i] >> 16) & 0xFF;
        $g = ($colors[$i] >> 8) & 0xFF;
        $b = $colors[$i] & 0xFF;

        $square = @imagecreatetruecolor($simulationSquare, $simulationSquare);
        //filling simulation
        $square = $this->colorizeBasedOnAlphaChannnel(base_path('public/icons/11.png'), $r, $g, $b, $simulationSquare);
        imagecopymerge($simulation, $square, $col * $simulationSquare, $row * $simulationSquare, 0, 0, $simulationSquare, $simulationSquare, 80);
        imagedestroy($square);
        $i++;
      }
    }

    ob_start();
    //from 0 (no compression) to 9
    imagepng($simulation, NULL, 9);
    $image_data = ob_get_contents();
    $imageName = str_random(10).'.'.'png';
    Storage::put('kristik/hasil_generate/'.$imageName, $image_data);
    ob_end_clean();
    if ($image_data) {
      // code...
      $generated = $model::create([
        'name' => $imageName,
        'file_path' => 'storage/app/kristik/hasil_generate/'.$imageName,
        'type' => 'kristik'
      ]);
      return response($generated);
    }
    else{
      return response(false);
    }
    imagedestroy($simulation);
  }


    public function colorizeBasedOnAlphaChannnel($file, $targetR, $targetG, $targetB, $squareSize) {
    	$im = imagecreatefrompng($file);

    	$im_src = imagecreatetruecolor($squareSize, $squareSize);
    	imagealphablending($im_src, false);
    	imagesavealpha($im_src, true);
    	imagecopyresampled($im_src, $im, 0, 0, 0, 0, $squareSize, $squareSize, 15, 15);

        $im_dst = imagecreatetruecolor($squareSize, $squareSize);
    	imagecopyresampled($im_dst, $im, 0, 0, 0, 0, $squareSize, $squareSize, 15, 15);

        // Note this:
        // Let's reduce the number of colors in the image to ONE
        // imagefilledrectangle($im_dst, 0, 0, $squareSize, $squareSize, 0xFFFFFF);

        for($x=0; $x<$squareSize; $x++) {
            for($y=0; $y<$squareSize; $y++) {

                $alpha = ( imagecolorat( $im_src, $x, $y ) >> 24 & 0xFF );

                $col = imagecolorallocatealpha( $im_dst,
                    $targetR - (int) ( 5.0 / 255.0  * $alpha * (double) $targetR ),
                    $targetG - (int) ( 5.0 / 255.0  * $alpha * (double) $targetG ),
                    $targetB - (int) ( 5.0 / 255.0  * $alpha * (double) $targetB ),
                    $alpha
                    );

                if ( false === $col ) {
                    die( 'maaf, diluar batas warna...' );
                }

                imagesetpixel( $im_dst, $x, $y, $col );

            }

        }

    	return $im_dst;
      imagedestroy($im_dst);
    }

}
