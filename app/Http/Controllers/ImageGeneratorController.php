<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ImageGeneratorController extends Controller{

  public function __construct()
  {  }

  public function generateImg(Request $request){
    ini_set('max_execution_time', 180); //3 minutes

    $data = json_decode($request->getContent(), true);
    //echo ($data["filename"]);

    $idFile = $request->input("filename") . str_random(3);
    $folderPath = url("public/img_temp") . "/";

    $fileName = 'generated_img_' . str_random(3);
    $command = "cd matlab_file/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"generateImg('".$fileName."'); exit;\"";

    exec($command, $execResult, $retval);

    return response()->json(array('error' => false,
      'message'=>'Generate image success',
      'exec_result' => $folderPath . $fileName . '.jpg'),
      200);
  }

  public function generateImg2(Request $request){
    ini_set('max_execution_time', 360); //6 minutes

    $sourceFileName = $request->input('sourceFile', 'potongansadum0.jpg');
    $fileName = $request->input("fileName") . str_random(3);
    $folderPath = url("public/img_temp") . "/";

    $fileName = "genImg". str_replace('.', '', $sourceFileName) . "_" . $fileName;
    $command = "cd matlab_file/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"generateImg('".$sourceFileName."', '".$fileName."'); exit;\"";

    exec($command, $execResult, $retval);

    return response()->json(array('error' => false,
      'message' => 'Generate image success',
      'filename' => $fileName,
      'exec_result' => $folderPath . $fileName . '.jpg'),
      200);
  }

  public function generateImg3(Request $request){
    ini_set('max_execution_time', 360);
    $treshold = $request->input('treshold', 0.8);

    $sourceFolderPath = '../public/img_src/';
    $resultFolderPath = '../public/img_temp/';

    $algo = $request->input('algoritma', "img_quilting");
    $sourceFileName = $request->input('sourceFile', 'potongansadum0.jpg');
    $resultFileName = "genImg" . str_replace('.', '', $sourceFileName) . "_" . $request->input("fileName") . str_random(3);

    $sourceFile = $sourceFolderPath . $sourceFileName;
    $resultFile = $resultFolderPath . $resultFileName . '.jpg';

    switch ($algo) {
      case 'img_quilting':
        $command = "cd matlab_file/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"img_quilting2('".$sourceFile."', '".$resultFile."', '.$treshold.'); exit;\"";
        exec($command, $execResult, $retval);

        return response()->json(array('error' => false,
          'message' => 'Generate image success',
          'filename' => $resultFileName,
          'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg'),
          200);
        break;

      case 'img_warp':
      
        break;
      default:
        case 'non_parametric_sample':
        break;
      return response()->json(array('error' => true,
        'message' => 'Undefined algoritma [' . $algo . ']'),
        200);
        break;
    }
  }

}
