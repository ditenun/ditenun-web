<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generate;
use App\Models\MotifTenun;

class ImageGeneratorController extends Controller{

  public function __construct()
  {  }

  private function validateParam(Request $request){
    $matrix = 'matrix';
    $color = 'color';
    $img_file = 'img_file';
    $msg = '';
    //$min_dimen = self::MAX_SIZE;

    // memory_limit=128M
    if(!$request->hasFile($img_file) || !in_array(strtolower($request->file($img_file)->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'tiff', 'gif', 'bmp'])/*|| number_format($request->file($img_file)->getSize() / 1048576, 2) > 2*/){
      if($msg=='')
        $msg .= $img_file;
      else $msg .= ', '.$img_file;
    }
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

  public function motif(Request $request){
    $msg = $this->validateParam($request);
    if($msg != ''){
      return response()->json(array(
        'message'=>$msg.' is not valid'
      ), 200);
    }
    ini_set('max_execution_time', 1500);

    $sourceFolderPath = 'public/img_src/param_temp/';
    $resultFolderPath = 'public/img_temp/param_temp/';
    $resultFileName = str_random(5);

    $matrix = $request->input('matrix');
    $color = $request->input('color');
    $image = $request->file('img_file');
    $extension = image_type_to_extension(getimagesize($image)[2]);
    $nama_file = $image->getClientOriginalName();
    $nama_file_save = pathinfo($nama_file, PATHINFO_FILENAME) .$extension;
    $nama_motif = pathinfo($nama_file, PATHINFO_FILENAME);
    $destinationPath = base_path('public\img_src\param_temp'); // upload path
    $image->move($destinationPath, $nama_file_save);

    $sourceFile = $destinationPath .'\\' . $nama_file_save;
    $resultFile = $resultFolderPath . $resultFileName.'.jpg';

    $command = "cd matlab_file/Image_Quilting/ && matlab -wait -nosplash -nodesktop -nodisplay -noFigureWindows -r \"imgQuilting3('"
      .$sourceFile."', '"
      .$resultFile."', "
      .$matrix."', "
      .$color.");exit; \"";

    exec($command, $execResult, $retval);
    if($retval == 1){
      $id = DB::table('generates')->insertGetId(['sourceFile' => $sourceFolderPath.$nama_file_save, 'generateFile' => $resultFile, 'nama_generate' => $resultFileName]);

      $destinationPath = base_path('public\img_temp\param_temp');
      $sourceFile = $destinationPath .'\\' . $nama_file_save;
      $imagedata = @file_get_contents($sourceFile);
      if(!$imagedata) return $this->errorReturn();
      $base64 = base64_encode($imagedata);
      $data = base64_decode($base64);
      $image = imagecreatefromstring($data);

      return response($image)->header('Content-Type','image/jpg');
    }
    return $this->errorReturn();
  }

  private function errorReturn(){
    return response()->json(array('error' => true,
        'message' => 'Generate motif failed'),
      200);
  }
}
