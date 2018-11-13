<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generate;
use App\Models\MotifTenun;

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
    ini_set('max_execution_time', 300); //6 minutes

    $sourceFileName = $request->input('sourceFile', 'potongansadum1.jpg');
    $fileName = $request->input("fileName") . str_random(3);
    $folderPath = url("public/img_temp") . "/";

    $fileName = "genImg". str_replace('.', '', $sourceFileName) . "_" . $fileName;
    $command = "cd matlab_file/img_quilting/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"generateImg('".$sourceFileName."', '".$fileName."'); exit;\"";

    exec($command, $execResult, $retval);

    return response()->json(array('error' => false,
      'message' => 'Generate image success',
      'filename' => $fileName,
      'exec_result' => $folderPath . $fileName . '.jpg'),
      200);
  }

  public function chekBluer(Request $request){
    ini_set('max_execution_time', 3600);

    $sourceFolderPath = '../../public/img_src/';
    $resultFolderPath = '../../public/img_temp/';

    $algo = $request->input('algoritma');
    $sourceFileName = $request->input('sourceFile', 'bintangmaratur.jpg');
    $resultFileName = "genImg" . str_replace('.', '', $sourceFileName) . "_" . $request->input("fileName") . str_random(3);

    $sourceFile = $sourceFolderPath . $sourceFileName;
    $resultFile = $resultFolderPath . $resultFileName . '.jpg';

  }

  public function generateImg3(Request $request){
    ini_set('max_execution_time', 3600);

    $sourceFolderPath = '../../public/img_src/';
    $resultFolderPath = '../../public/img_temp/';

    $algo = $request->input('algoritma');
    $sourceFileName = $request->input('sourceFile', 'potongansadum0.jpg');
    $resultFileName = "genImg" . str_replace('.', '', $sourceFileName) . "_" . $request->input("fileName") . str_random(3);

    $sourceFile = $sourceFolderPath . $sourceFileName;
    $resultFile = $resultFolderPath . $resultFileName . '.jpg';

    switch ($algo) {
      case 'img_quilting2':
        $treshold = $request->input('treshold_similarity', 80);
        $treshold = $treshold / 100;

        $command = "cd matlab_file/img_quilting/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"img_quilting2('"
          .$sourceFile."', '"
          .$resultFile."', "
          .$treshold."); exit;\"";

        exec($command, $execResult, $retval);

        return response()->json(array('error' => false,
          'message' => 'Generate image success',
          'filename' => $resultFileName,
          'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg',
          'algoritma' => $algo),
          200);

        break;

      case 'img_warping':
        $intp_method = $request->input('interpolar_method', 'invdist');
        $intp_radius = $request->input('interpolar_radius', 5);
        $intp_power = $request->input('interpolar_power', 2);

        $command = "cd matlab_file/img_warping/ && matlab -wait -nosplash -nodesktop -nodisplay -r "
                    ."\"tpsWarpDemo('".$sourceFile."', '"
                    .$resultFile."', "
                    ."'map.mat', "
                    ."'tpsDemoLandmark.mat', '"
                    .$intp_method."', "
                    .$intp_radius.", "
                    .$intp_power
                    ."); exit;\"";

        exec($command, $execResult, $retval);

        return response()->json(array('error' => false,
          'message' => 'Generate image success',
          'filename' => $resultFileName,
          'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg',
          'algoritma' => $algo),
          200);

        break;
      case 'img_quilting':
          $square = $request->input('square', 1);
          $matrix = $request->input('matrix', 4);
          $Panjang = $request->input('panjang', 300);
          $warna = $request->input('warna', 1);
          // $treshold = $treshold / 100;

          $command = "cd matlab_file/Image_Quilting/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"imgQuilting('"
            .$sourceFile."', '"
            .$resultFile."', "
            .$square."', "
            .$Panjang."', "
            .$matrix."', "
            .$warna."); exit;\"";

          exec($command, $execResult, $retval);

          return response()->json(array('error' => false,
            'message' => 'Generate image success',
            'filename' => $resultFileName,
            'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg',
            'algoritma' => $algo),
            200);

          break;
      case 'img_nps':
      $square = $request->input('square', 1);
      $matrix = $request->input('matrix', 4);
      $Panjang = $request->input('panjang', 300);
      $warna = $request->input('warna', 1);
          // $treshold = $treshold / 100;

          $command = "cd matlab_file/NPS/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"GenerateImgWithNps('"
              .$sourceFile."', '"
              .$resultFile."', "
              .$square."', "
              .$matrix."', "
              .$Panjang."', "
              .$warna."); exit;\"";

          exec($command, $execResult, $retval);

          return response()->json(array('error' => false,
                'message' => 'Generate image success',
                'filename' => $resultFileName,
                'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg',
                'algoritma' => $algo),
                200);

          break;
      case 'non_parametric_sample':
        $block_size = $request->input('block_size', 10);

        $command = "cd matlab_file/non_parametric/ && matlab -wait -nosplash -nodesktop -nodisplay -r "
                    ."\"nps_main('".$sourceFile."', '"
                    .$resultFile."', "
                    .$block_size
                    ."); exit;\"";

        exec($command, $execResult, $retval);

        return response()->json(array('error' => false,
          'message' => 'Generate image success',
          'filename' => $resultFileName,
          'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg',
          'algoritma' => $algo),
          200);

        break;
      default:
          return response()->json(array('error' => true,
          'message' => 'Undefined algoritma [' . $algo . ']'),
          200);
        break;
    }
  }


  public function generateNewMotif(Request $request){
    ini_set('max_execution_time', 1000);

    $sourceFolderPath = '../../public/img_src/';
    $resultFolderPath = '../../public/img_temp/';

    $algo = $request->input('algoritma');
    $sourceFileName = $request->input('sourceFile', 'potongansadum0_128.jpg');
    // $resultFileName = "genImg" .str_random(3) .'_'. str_replace('.', '.', $sourceFileName);
    // $resultFileName = "genImg" . str_replace('.', '', $sourceFileName) . "_" . str_random(3);
    $resultFileName = "genImg_" . $sourceFileName . "_" . str_random(5);



    // $motif = DB::table('motif_tenuns')->where('nama_motif', $new_array[0])pluck('id');
    $motif =  MotifTenun::find($request->input('idMotif'));

    // var_dump($motif->id);

    $sourceFile = $sourceFolderPath . $sourceFileName .'.jpg';
    $resultFile = $resultFolderPath . $resultFileName;
    $modelGenerate = $request->input('model');
    $warnaGenerate = $request->input('warna');

    #default matrix
    $matrix = 2;

    if($modelGenerate=='Model-1'){
      $matrix = 2;
    }else if($modelGenerate == 'Model-2'){
      $matrix = 3;
    }else if($modelGenerate == 'Model-3'){
      $matrix = 4;
    }

    #default warna
    $warna = 1;
    if($warnaGenerate == 'Asli'){
      $warna = 1;
    }else if($warnaGenerate == 'Warna-Warni'){
      $warna = 4;
    }else if($warnaGenerate == 'Hitam-Putih'){
      $warna = 5;
    }

    switch ($algo) {

        case 'img_quilting':
          $command = "cd matlab_file/Image_Quilting/ && matlab -wait -nosplash -nodesktop -nodisplay -noFigureWindows -r \"imgQuilting3('"
            .$sourceFile."', '"
            .$resultFile."', "
            .$matrix."', "
            .$warna.");exit; \"";


          exec($command, $execResult, $retval);
          // if($retval==1){
            //for($i=1; $i<=2; $i++){
              $id = DB::table('generates')->insertGetId(
              ['idMotif' => $motif->id, 'generateFile' => 'public/img_temp/'. $resultFileName .'.jpg', 'nama_generate'=>$resultFileName]
            );
            //}
          // }

          return response()->json(array('error' => false,
            'message' => 'Generate image success',
            'filename' => $resultFileName,
            'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg',
            'data'=> Generate::where('idMotif', $motif->id)->get(),
            'algoritma' => $algo),
            200);

          break;

      case 'img_nps':
          // $treshold = $treshold / 100
          $command = "cd matlab_file/NPS/ && matlab -wait -nosplash -nodesktop -nodisplay -noFigureWindows -r \"imgNPS('"
              .$sourceFile."', '"
              .$resultFile."', "
              .$matrix."', "
              .$warna."); exit;\"";

              $id = DB::table('generates')->insertGetId(
              ['idMotif' => $motif->id, 'generateFile' => 'public/img_temp/'. $resultFileName . '.jpg', 'nama_generate'=>$resultFileName]
            );
          exec($command, $execResult, $retval);

          if($retval==1){
            return response()->json(array('error' => false,
                  'message' => 'Generate image success',
                  'filename' => $resultFileName,
                  'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg',
                  'data'=> Generate::find($id),
                  'algoritma' => $algo),
                  200);
                break;
          }else{
            return response()->json(array('error' => true,
                  'message' => 'Generate image failed',
                  'filename' => $resultFileName,
                  'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg',
                  'algoritma' => $algo),
                  200);

            break;
          }

      default:
          return response()->json(array('error' => true,
          'message' => 'Undefined algoritma [' . $algo . ']'),
          200);
        break;
    }
  }

  public function buatMotifBaru(Request $request){
    ini_set('max_execution_time', 1000);
    $sourceFolderPath = '../../public/img_src/';
    $resultFolderPath = '../../public/img_temp/';

    $sourceFileName = $request->input('sourceFile', 'potongansadum0_128');
    $resultFileName = "genImg_" . $sourceFileName . "_" . str_random(5);

    $motif =  MotifTenun::find($request->input('idMotif'));

    $sourceFile = $sourceFolderPath . $sourceFileName .'.jpg';
    $resultFile = $resultFolderPath . $resultFileName;

    $matrix = rand(2,5);
    $warna = rand(1,5);
    $command = "cd matlab_file/Image_Quilting/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"imgQuilting4('"
    .$sourceFile."', '"
    .$resultFile."', "
    .$matrix."', "
    .$warna.");exit; \"";

    exec($command, $execResult, $retval);
    $id = DB::table('generates')->insertGetId(
    ['idMotif' => $motif->id, 'generateFile' => 'public/img_temp/'. $resultFileName . '.jpg', 'nama_generate'=>$resultFileName]);

    return response()->json(array('error' => false,
      'message' => 'Generate image success',
      'filename' => $resultFileName,
      'exec_result' => url("public/img_temp") . "/" . $resultFileName . '.jpg',
      'data'=> Generate::find($id)),
      200);
  }

}
