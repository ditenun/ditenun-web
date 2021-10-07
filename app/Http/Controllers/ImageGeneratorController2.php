<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generate;
use App\Models\MotifTenun;

class ImageGeneratorController2 extends Controller{
  const MODEL = "App\Models\MotifTenun";
  const MODELTRANSPARANT = "App\Models\TransparantImageKristik";

  public function __construct()
  {  }

  private function validateParam(Request $request){
    $matrix = 'matrix';
    $color = 'color';
    // $img_file = 'img_file';
    $msg = '';
    //$min_dimen = self::MAX_SIZE;

    // memory_limit=128M
    // if(!$request->hasFile($img_file) || !in_array(strtolower($request->file($img_file)->getClientOriginalExtension()), ['jpg', 'jpeg', 'png'/*, 'tiff', 'gif', 'bmp'*/])/*|| number_format($request->file($img_file)->getSize() / 1048576, 2) > 2*/){
    //   if($msg=='')
    //     $msg .= $img_file;
    //   else $msg .= ', '.$img_file;
    // }
    // 2 = Model-1, 3 = Model-2, 4 = Model-3
    if($request->input($matrix) == null || strval($request->input($matrix)) !== strval(intval($request->input($matrix))) || intval($request->input($matrix)) < 2 || intval($request->input($matrix)) > 4){
      if($msg=='')
        $msg .= $matrix;
      else $msg .= ', '.$matrix;
    }
    // 1 = Asli, 4 = Warna-warni, 5 = Hitam Putih
    if($request->input($color) == null || strval($request->input($color)) !== strval(intval($request->input($color))) || !in_array(intval($request->input($color)), [1, 4, 5])){
      if($msg=='')
        $msg .= $color;
      else $msg .= ', '.$color;
    }
    return $msg;
  }

  public function testing() {
	  $msg = 'Testing';


	  return $msg;

  }
  public function motif(Request $request){
    $msg = $this->validateParam($request);
    if($msg != ''){
      return response()->json(array(
        'message'=>$msg.' is not valid'
      ), 200);
    }
    ini_set('max_execution_time', 4000);
    $modelTransparant = self::MODELTRANSPARANT;
    // $image = imagecreatefromstring(file_get_contents($request->input('filename')));

    $sourceFolderPath = 'public/img_src/param_temp/before/';
    $resultFolderPath = base_path('storage\app\motif');
    $resultFileName = str_random(10).'.'.'png';
    // $sourceFileName = str_random(10);
    //
    $matrix = $request->input('matrix');
    $color = $request->input('color');
    $filename = $modelTransparant::where('id',$request->input('id_transparant'))->value('file_path');

    if(empty($filename))
    return response()->json(array('success' => false,
      'message'=>'Get item failed, no item found',
      'data' => $filename),
      404);

    // // $image = $request->file('img_file');
    // $extension = image_type_to_extension(getimagesize($image)[2]);
    // $nama_file_save = $sourceFileName.$extension;
    $destinationPath = base_path(''); // upload path
    // $image->move($destinationPath, $nama_file_save);
    //
    $sourceFile = $destinationPath .'\\' . $filename;
    $resultFile = $resultFolderPath .'\\'. $resultFileName;
    // $filename = $resultFileName.'.png';
    $random = rand(30,1000);

    $command = "cd matlab_file/Image_Quilting2/ && matlab -wait -nosplash -nodesktop -nodisplay -noFigureWindows -r \"imgQuilting3('"
      .$sourceFile."', '"
      .$resultFile."', "
      .$matrix."', "
      .$random."'',"
      .$color.");exit; \"";

    exec($command, $execResult, $retval);
      $destinationPath = base_path('storage\app\motif');
      $fullPath = 'storage/app/motif/'.$resultFileName;
      // $fullPath = $destinationPath .'\\' . $resultFileName;
      $imagedata = file_get_contents($fullPath);
      if(!$imagedata) return $this->errorReturn();

      $model = self::MODEL;
      $generate =  $model::create([
          'name' => $resultFileName,
          'file_path' => $fullPath,
      ]);
      $gen = json_encode($generate, JSON_UNESCAPED_SLASHES);
      return response($gen);
   return $this->errorReturn();
  }

  private function errorReturn(){
    return response()->json(array('error' => true,
        'message' => 'Generate motif failed'),
      200);
  }
}
