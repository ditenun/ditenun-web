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
          $sourceFolderPath = 'C:\xampp\htdocs\api-tenun\storage\public\img_src';
          $image = $request->file('photo');
          $sourceFileName =  $image->getClientOriginalName() . str_random(3) .'.jpg';
          $destinationPath = storage_path('/public/img_src');
          $image->move($destinationPath, $sourceFileName);
          $sourceFile = $sourceFolderPath .'\\' . $sourceFileName;
          $test = escapeshellarg($sourceFile);
          $process = new Process("python C:/xampp/htdocs/api-tenun/python_file/Ulos.py \"{$sourceFile}\"");
          $process->run();
          // executes after the command finishes
          if (!$process->isSuccessful()) {
              throw new ProcessFailedException($process);
          }

          $output = $process->getOutput();
          $nama_ulos = file_get_contents('C:\xampp\htdocs\api-tenun\klasifikasi_good_ori.txt');
          if($nama_ulos =="Ulos Mangiring"){
            $id_tenun = 1;
          }else if($nama_ulos =="Ulos Ragi Hidup"){
            $id_tenun = 2;
          }else if($nama_ulos =="Ulos Sitolutuho"){
            $id_tenun = 3;
          }else if($nama_ulos =="Ulos Harungguan"){
            $id_tenun = 4;
          }else if($nama_ulos =="Ulos Ragi Hotang"){
            $id_tenun = 5;
          }else if($nama_ulos =="Ulos Sibolang"){
            $id_tenun = 6;
          }else if($nama_ulos =="Ulos Bintang Maratur"){
            $id_tenun = 7;
          }else if($nama_ulos =="Ulos Sadum"){
            $id_tenun = 8;
          }

          $id = DB::table('ulos')->insertGetId(
            ['id_category' => $id_tenun, 'image_name' => $sourceFileName, 'image_path' => "storage/public/img_src/"]
          );

          return response()->json(array('success' => true,
                'message' => $nama_ulos,
              'data' => Ulos::find($id),
              'Output' => $output),
                200);

          }else{
            return response()->json(array('success' => false,
              'message' => 'Ulos Classification Failed'),
              200);
          }

    }

    public function getListUlos(Request $request){

      // if($size == 'all')
        $listUlos = DB::table('ulos')->get();
      // else
      //   $listUlos = DB::table('ulos')->skip($cursor)->take($size)->get();

      if(!count($listUlos))
      return response()->json(array('success' => false,
        'message'=>'Get item failed, no item found',
        'data' => $listUlos),
        404);

      return response()->json(array('error' => false,
        'message'=>'Get list item success',
        'data' => $listUlos),
        200);
    }

    public function getListUlosByIdCategory($id){

      $listUlos = DB::table('ulos')->where(['id_category'=>$id])->get();

      if(!count($listUlos))
        return response()->json(array('success' => false,
        'message'=>'Get item failed, no item found',
        'data' => $listUlos),
        404);
      else
        return response()->json(array('error' => false,
        'message'=>'Get list item success',
        'data' => $listUlos),
        200);
    }

}
