<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JenisUlos;
use App\Models\OriginalImage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use File;

class OriginalImageController extends Controller{
  private $limit_per_page = 9;


  public function __construct()
  {  }

  private function validateParam(Request $request){
    $id_jenis_ulos = 'Jenis Ulos';
    $msg = '';

    $validateJenisUlos = JenisUlos::where('idUlos',$request->input('id_jenis_ulos'))->value('namaUlos');

    if (empty($validateJenisUlos)) {
      // code...
      $msg = ''.$id_jenis_ulos;
    }

    return $msg;
  }



  public function insertImage(Request $request){
    $msg = $this->validateParam($request);
    if($msg != ''){
        return response()->json(array('success' => false,
          'message'=>'Get item failed, no item found',
          'data' => $msg.' not found'),
          404);
    }
    else{
      $image = $request->file('img_file');
      $extension = image_type_to_extension(getimagesize($image)[2]);
      $name_file = $request->get('name_image');//$image->getClientOriginalName();
      $nama_file_save = pathinfo($name_file, PATHINFO_FILENAME) .$extension;
      //$nama_motif = pathinfo($nama_file, PATHINFO_FILENAME);
      $destinationPath = base_path('storage\app\originalImage'); // upload path
      // Save Original Image
      $uploadFileName = str_random(10).'.'.'png';
      $image->move($destinationPath, $uploadFileName);

      $description=$request->get('description');
      $jenisUlos=$request->get('id_jenis_ulos');

      $generated = OriginalImage::create([
            'name_image' => $name_file,
            'id_jenis_ulos' => $jenisUlos,
            'path' => 'storage/app/originalImage/'.$nama_file_save,
            'description' => $description
          ]);
      return response($generated);
    }

  }

  public function getAllImage(){
    // $modelGenerate = self::MODEL;

    $allImage = OriginalImage::orderBy('id', 'asc')
    ->paginate($this->limit_per_page);

    $response = [
        'pagination' => [
            'total' => $allImage->total(),
            'per_page' => $allImage->perPage(),
            'current_page' => $allImage->currentPage(),
        ],
        'data' => $allImage
    ];
    return response()->json($response);
  }

  public function getAllImagebyJenisUlos($idJenisUlos){
    $allImage = OriginalImage::where([
      'id_jenis_ulos' => $idJenisUlos,
      ])->orderBy('id', 'asc')
    ->paginate($this->limit_per_page);

    $response = [
        'pagination' => [
            'total' => $allImage->total(),
            'per_page' => $allImage->perPage(),
            'current_page' => $allImage->currentPage(),
        ],
        'data' => $allImage
    ];
    return response()->json($response);
  }
}
