<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generate;
use App\Models\MotifTenun;

class ImageGenerator4Controller extends Controller{

  public function __construct()
  {  }

  private function validateParam(Request $request){
    $matrix = 'matrix';
    $color = 'color';
    $img_file = 'img_file';
    $msg = '';
    //$min_dimen = self::MAX_SIZE;

    // memory_limit=128M
    if(!$request->hasFile($img_file) || !in_array(strtolower($request->file($img_file)->getClientOriginalExtension()), ['jpg', 'jpeg', 'png'/*, 'tiff', 'gif', 'bmp'*/])/*|| number_format($request->file($img_file)->getSize() / 1048576, 2) > 2*/){
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

    $sourceFolderPath = 'public/img_src/param_temp/before/';
    $compressFolderPath = 'public/img_src/param_temp/temp_copied/';
    $sourceFolderPath = 'public/img_src/param_temp/before/';
    $resultFolderPath = base_path('public\img_src\param_temp\after');
    $resultFileName = str_random(10);
    $sourceFileName = str_random(10);
    $matrix = $request->input('matrix');
    $color = $request->input('color');
    $image = $request->file('img_file');
    $extension = image_type_to_extension(getimagesize($image)[2]);
    $nama_file_save = $sourceFileName.$extension;
    $destinationPath = base_path('public\img_src\param_temp\before'); // upload path
    $image->move($destinationPath, $nama_file_save);
    $sourceFile = $destinationPath .'\\' . $nama_file_save;
    $resultFile = $resultFolderPath .'\\'. $resultFileName.'.jpg';

    // compress file
    copy('public/img_src/param_temp/before/' . $nama_file_save, 'public/img_src/param_temp/temp_copied/' . $nama_file_save);
    $compress_src = 'cd public/img_src/param_temp/before/ && magick convert -strip -quality 75% '. $nama_file_save . ' ' . $nama_file_save . ' & exit';

    exec($compress_src, $res, $val);
    if ($val != 0) {
      return $this->errorReturn();
    }

    $sourceCompressFile = $compressFolderPath . $nama_file_save;
    $command = "cd matlab_file/Image_Quilting/ && matlab -wait -nosplash -nodesktop -nodisplay -noFigureWindows -r \"imgQuilting3('"
      .$sourceFile."', '"
      .$resultFile."', "
      .$matrix."', "
      .$color.");exit; \"";

    exec($command, $execResult, $retval);
    if($retval == 0){
      $id = DB::table('generates')->insertGetId(['sourceFile' => $compressFolderPath.$nama_file_save, 'generateFile' => $resultFile, 'nama_generate' => $resultFileName]);

      // return generated image in content type image
      $destinationPath = base_path('public\img_src\param_temp\after');
      $sourceFile = $destinationPath .'\\' . $resultFileName.'.jpg';
      $imagedata = file_get_contents($sourceFile);
      if(!$imagedata) return $this->errorReturn();
      $base64 = base64_encode($imagedata);
      $data = base64_decode($base64);
      //$image = imagecreatefromstring($data);

      return response($data)->header('Content-Type','image/jpg');
    }
    return $this->errorReturn();
  }

  private function errorReturn(){
    return response()->json(array('error' => true,
        'message' => 'Generate motif failed'),
      200);
  }
}
