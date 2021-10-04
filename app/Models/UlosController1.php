<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ulos;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UlosController extends Controller{

  public function __construct()
  {  }

  public function ulosClassification(Request $request){
    ini_set('max_execution_time', 180); //3 minutes
        if ($request->hasFile('photo')) {
          $sourceFolderPath = 'C:\xampp\htdocs\ModulTerbaru\api-tenun\storage\public\img_src';
          $image = $request->file('photo');
          $nama_motif = $image->getClientOriginalName() . str_random(3);
          $sourceFileName =  $nama_motif .'.jpg';
          $img_src = 'public/img_src/' .$sourceFileName;
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
          $nama_ulos = file_get_contents('C:\xampp\htdocs\ModulTerbaru\api-tenun\klasifikasi_good_ori.txt');
          // if($nama_ulos =="Ulos Mangiring"){
          //   $id_tenun = 23;
          // }else if($nama_ulos =="Ulos Ragi Hidup"){
          //   $id_tenun = 16;
          // }else if($nama_ulos =="Ulos Sitolutuho"){
          //   $id_tenun = 24;
          // }else if($nama_ulos =="Ulos Harungguan"){
          //   $id_tenun = 10;
          // }else if($nama_ulos =="Ulos Ragi Hotang"){
          //   $id_tenun = 5;
          // }else if($nama_ulos =="Ulos Sibolang"){
          //   $id_tenun = 6;
          // }else if($nama_ulos =="Ulos Bintang Maratur"){
          //   $id_tenun = 4;
          // }else if($nama_ulos =="Ulos Sadum"){
          //   $id_tenun = 15;
          // }

          //$id = DB::table('motif_tenuns')->insertGetId(['id_tenun' => $id_tenun, 'nama_motif' => $nama_motif, 'img_src' => $img_src]);
          return response()->json(array(
            'success'=>True,
            'message'=>$nama_ulos),
            200);
        }else{
          return response()->json(array('success'=>False,
            'message'=>"Classification error"),
            200);
        }

    }



}
