<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MotifTenun;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use File;

class ImageQualityController extends Controller{

  public function __construct()
  {  }

  public function uploadImage(Request $request){
    ini_set('max_execution_time', 180); //3 minutes
    if ($request->hasFile('photo')) {
      $image = $request->file('photo');
      // $nama_motif = $request->input('nama_motif');
      $nama_ulos = $request->input('nama_tenun');
      $id_tenun= $request->input('id_tenun');;
      // if($nama_ulos =="Ulos Bintang Maratur"){
      //   $id_tenun = 4;
      // }else if($nama_ulos =="Ulos Ragihotang"){
      //   $id_tenun = 5;
      // }else if($nama_ulos =="Ulos Sibolang"){
      //   $id_tenun = 6;
      // }else if($nama_ulos =="Ulos Harungguan"){
      //   $id_tenun = 10;
      // }else if($nama_ulos =="Ulos Sadum"){
      //   $id_tenun = 15;
      // }else if($nama_ulos =="Ulos Ragiidup"){
      //   $id_tenun = 16;
      // }else if($nama_ulos =="Ulos Mangiring"){
      //   $id_tenun = 23;
      // }else if($nama_ulos =="Ulos Sitoluntuho"){
      //   $id_tenun = 24;
      // }

      // $name =  time().'.'.$image->getClientOriginalExtension();
      $nama_file = $image->getClientOriginalName();
      $nama_motif = pathinfo($nama_file, PATHINFO_FILENAME);

      $destinationPath = base_path('public/img_src'); // upload path
      $request->file('photo')->move($destinationPath, $nama_file);
      $img_src = "public/img_src/" .$nama_file;
      $id = DB::table('motif_tenuns')->insertGetId(['id_tenun' => $id_tenun, 'nama_motif' => $nama_motif, 'img_src' => $img_src]);
      return response()->json(array('error' => false,
        'success'=>True,
        'message'=>'Image uploaded',
        'motifTenun' => MotifTenun::find($id)),
        200);
    }else{
      return response()->json(array('error' => true,
        'data'=>"image must selected"),
        200);
    }
  }

  public function checkNoise(Request $request){
    ini_set('max_execution_time', 180); //3 minutes
        if ($request->hasFile('photo')) {
          $sourceFolderPath = 'C:\\xampp\htdocs\ModulTerbaru\api-tenun\storage\public\img_src';
          $image = $request->file('photo');
          $sourceFileName =  $image->getClientOriginalName();
          $destinationPath = storage_path('/public/img_src');
          $folderPath = url("public/img_src") . "/";
          $image->move($destinationPath, $sourceFileName);
          $sourceFile = $sourceFolderPath .'\\' . $sourceFileName;
          $command = "cd matlab_file/img_noise/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"checkNoise('"
            .$sourceFile .'\''."); exit;\"";
          exec($command, $execResult, $retval);

          if($retval==0){
            //Print Saved results from file
              $checkNoise = file_get_contents('C:\\xampp\\htdocs\\ModulTerbaru\\api-tenun\\matlab_file\\img_noise\\result.txt');
              $temp = explode(" ", $checkNoise)[2];
              $message = "";
              if($temp < 1){
                $message = "Good";
              }else{
                $message = "Good";
              }

              return response()->json(array('success' => true,
                'message' => $message),
                200);
          }else{
            return response()->json(array('success' => false,
              'message' => 'Check Noise Error',
              'checkNoise' => $retval),
              200);
          }
      }
    }

    public function checkBlur(Request $request){
      ini_set('max_execution_time', 180); //3 minutes
          if ($request->hasFile('photo')) {
            $sourceFolderPath = 'C:\xampp\htdocs\ModulTerbaru\api-tenun\storage\public\img_src';
            $image = $request->file('photo');
            $sourceFileName =  $image->getClientOriginalName() . str_random(3) .'.jpg';
            $destinationPath = storage_path('/public/img_src');
            $image->move($destinationPath, $sourceFileName);
            $sourceFile = $sourceFolderPath .'\\' . $sourceFileName;
            $test = escapeshellarg($sourceFile);
            $process = new Process("python C:/xampp/htdocs/ModulTerbaru/api-tenun/python_file/Ulos.py \"{$sourceFile}\"");
            $process->run();
            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output = $process->getOutput();
            $message = file_get_contents('C:\xampp\htdocs\ModulTerbaru\api-tenun\result.txt');

            return response()->json(array('success' => true,
                  'message' => $message),
                  200);
            }else{
              return response()->json(array('success' => false,
                'message' => 'Check Noise Error'),
                200);
            }
        }

}
