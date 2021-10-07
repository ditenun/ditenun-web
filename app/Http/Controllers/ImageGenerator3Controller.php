<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Generate;
use App\Models\MotifTenun;

// (float)rand() / (float)getrandmax()

class ImageGenerator3Controller extends Controller{

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

    $command = "cd matlab_file/Image_Quilting/ && matlab -wait -nosplash -nodesktop -nodisplay -r \"imgQuilting4('"
      .$sourceFile."', '"
      .$resultFile."', "
      .$matrix."', "
      .$color.");exit; \"";

    $m1[] = [1, 2, 3];
    $m1[] = [2, 3, 1];
    $m1[] = [3, 1, 2];

    $m2[] = [1, 2];
    $m2[] = [3, 4];

    exec($command, $execResult, $retval);
    $temp = $this->imgQuilting($sourceFile, $resultFile, $matrix, $color);
    return $temp;
    //return response($temp)->header('Content-Type','image/jpg');
    if($retval == 0){
      $id = DB::table('generates')->insertGetId(['sourceFile' => $sourceFolderPath.$nama_file_save, 'generateFile' => $resultFile, 'nama_generate' => $resultFileName]);

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

  private function imgQuilting($src_file, $res_file, $matrix=2, $color=1){
    $imagedata = file_get_contents($src_file);
    $base64 = base64_encode($imagedata);
    $data = base64_decode($base64);
    $source = imagecreatefromstring($data);
    $sz = $this->getImgSize($source);
    $height = $sz[0];
    $width = $sz[1];
    $dim = $sz[2];
    $temp_height = $height;
    $temp_width = $width;

    $mod_width = $width%2;
    $mod_height = $height%2;
    $new_size = $height;
    if($width > $height && $mod_width != 0)
      $new_size = $width + 1;
    else if($width > $height)
        $new_size = $width;
    else if($mod_height != 0)
        $new_size = $new_size + 1;
    //810
    if($new_size > 810)
      $new_size = 810;

    $src_resized = imagecreatetruecolor($new_size, $new_size);
    imagecopyresampled($src_resized, $source, 0, 0, 0, 0, $new_size, $new_size, $width, $height);
    imagedestroy($source);
    $sz = $this->getImgSize($src_resized);
    $width = $sz[0];
    $height = $sz[1];
    $dim = $sz[2];

    $outsize_var = 0.5;
    $outsize = $this->multMatrix1DimToNum($sz, $outsize_var);
    $tilesize = floor((($width)/2)*0.8);
    $overlapsize = ($tilesize*2) - floor(($width)/2);
    $isdebug = 0;
    $imgMirror_original = $this->synthesize($src_resized, $outsize, $tilesize, $overlapsize, $isdebug);
    return $imgMirror_original;
    // ob_start();
    // imagejpeg($src_resized);
    // $image_data = ob_get_contents();
    // ob_end_clean();

    imagedestroy($src_resized);
    return $image_data;

    //return $src_resized;
  }

  private function synthesize($imin, $sizeout, $tilesize, $overlap, $isdebug){
    $imout = $this->gen3DimArrayVal($sizeout[0], $sizeout[1], 0);
    $imout[0][0][0] = 255;
    $imout[1][0][0] = 255;
    $imout[2][0][0] = 255;
    $sizein = [imagesx($imin), imagesy($imin)];
    $imin_matrix = $this->imgToMatrixRgb($imin);
    $imin_pow = $this->pow3dMatrix($imin_matrix);

    $temp = $this->gen2DimArrayVal($overlap, $tilesize, 1);
    $errtop = $this->getxcorr2($imin_pow, $temp);
    $temp = $this->gen2DimArrayVal($tilesize, $overlap, 1);
    $errside = $this->getxcorr2($imin_pow, $temp);
    $temp = $this->gen2DimArrayVal($tilesize-$overlap, $overlap, 1);
    $errsidesmall = $this->getxcorr2($imin_pow, $temp);

    for($i=0;$i<$sizeout[0]-$tilesize+1;$i+$tilesize-$overlap){
      for($j=0;$j<$sizeout[1]-$tilesize+1;$j+$tilesize-$overlap){
        if($i>0 && $j>0){
          //extract top shared region
          $shared = $this->getSubMatrix3d($imout, 0, 2, $j, $j+$tilesize-1, $i, $i+$overlap-1);
          $err = $this->matrixAddToNum($this->matrixMin2d($errtop, $this->multMatrix2DimToNum($this->getxcorr2($imin_matrix, $shared), 2)), $this->matrixSum1d($this->pow1dMatrix($this->matrix3DimTo1Dim($shared))));

          $err = $this->getSubMatrix2d($err, $tilesize, count($err)-$tilesize+1, $overlap, count($err[0])-$tilesize+1);

          $shared = $this->getSubMatrix3d($imout, 0, 2, $j, $j+$overlap-1, $i+$overlap, $i+$tilesize-1);
          $err2 = $this->matrixAddToNum($this->matrixMin2d($errsidesmall, $this->multMatrix2DimToNum($this->getxcorr2($imin_matrix, $shared), 2)), $this->matrixSum1d($this->pow1dMatrix($this->matrix3DimTo1Dim($shared))));

          $err = $this->matrixAdd($err, $this->getSubMatrix2d($err2, $overlap, count($err2)-$tilesize+1, $tilesize, count($err2[0])-$tilesize+$overlap+1));

          $temp999 = $this->matrixFindLowEq($err, 1.1*1.01*min($this->matrix2DimTo1Dim($err)));
          $ibest = $temp999[0];
          $jbest = $temp999[1];
          $c = ceil(((float)rand()/(float)getrandmax()) * count($ibest));
          $pos = [$ibest[$c], $jbest[$c]];

          $B1overlaph = $this->getSubMatrix3d($imout, 0, 2, $j, $j+$tilesize-1, $i, $i+$overlap-1);
          $B2overlaph = $this->getSubMatrix3d($imin, 0, 2, $pos[1], $pos[1]+$tilesize-1, $pos[0], $pos[0]+$overlap-1);

          $errmat = $this->matrixSum2d($this->pow3dMatrix($this->matrixMin3d($B1overlaph, $B2overlaph))[2]);

          $fph = $this->gen2DimArrayVal($overlap, $tilesize, 0);
          $pathh = $this->gen2DimArrayVal($overlap, $tilesize, 0);

          $this->matrixChangeSpecCol($fph, $errmat, $tilesize-1);

          for($k=$tilesize-1;$k>=1;$k--){
              for($l=1;$l<=$overlap;$l++){
                  $index = $this->matrixVectorGen(max(1,$l-1), min($overlap, $l+1));
                  $temp999 = $this->minIndex($this->matrixGetVal1($fph, $index, $k+1));
                  $fph[$l][$k] = $temp999[0];
                  $temp_index = $temp999[1];
                  $fph[$l][$k] = $fph[$l][$k] + $errmat[$l][$k];
                  $pathh[$l][$k] = $index[$temp_index];
              }
          }

          $B1overlap = $this->getSubMatrix3d($imout, 0, 2, $j, $j+$overlap-1, $i, $i+$tilesize-1);
          $B2overlap = $this->getSubMatrix3d($imin, 0, 2, $pos[1], $pos[1]+$overlap-1, $pos[0], $pos[0]+$tilesize-1);

          $errmat = $this->matrixSum2d($this->pow3dMatrix($this->matrixMin3d($B1overlap, $B2overlap))[2]);

          $fp = $this->gen2DimArrayVal($tilesize, $overlap, 0);
          $path = $this->gen2DimArrayVal($tilesize, $overlap, 0);

          //$fp[$tilesize-1] = $errmat[$tilesize-1];
          $fp[$tilesize-1] = $errmat[$tilesize-1];

          for($k=$tilesize-1;$k>=1;$k--){
              for($l=1;$l<=$overlap;$l++){
                  $index = $this->matrixVectorGen(max(1,$l-1), min($overlap, $l+1));
                  $temp999 = $this->minIndex($this->matrixGetVal2($fp, $k+1, $index));
                  $fp[$k][$l] = $temp999[0];
                  $temp_index = $temp999[1];
                  $fp[$k][$l] = $fp[$k][$l] + $errmat[$k][$l];
                  $path[$k][$l] = $index[$temp_index];
              }
          }
          $allerr = $this->matrixAdd($this->getSubMatrix2d($fp, 0, $overlap, 0, $overlap), $this->getSubMatrix2d($fph, 0, $overlap, 0, $overlap));

          $temp999 = $this->minIndex2d($allerr);
          $min_bound_indexi = $temp999[1];
          $min_bound_indexj = $temp999[2];

          //imout(i+ overlap : i+tilesize-1,j + overlap : j+ tilesize-1,:) = ...
          //    imin(pos(1)+overlap :pos(1)+tilesize-1,pos(2)+overlap :pos(2)+tilesize-1,:);
        }
      }
    }

    return $errtop;
  }

  private function matrixChangeSpecCol(&$m1, $m2, $col){
    for($i=0;$i<count($m1);$i++){
      $m1[$i][$col] = $m2[$i][$col];
    }
  }

  private function minIndex($arr){
    $index = 0;
    $min = $arr[$index];
    for($i=1;$i<count($arr);$i++){
      if($arr[$i]<$min){
        $index = $i;
        $min = $arr[$index];
      }
    }
    return [$min, $index];
  }

  private function minIndex2d($arr){
    $indexi = 0;
    $indexj = 0;
    $min = $arr[$indexi][$indexj];
    for($i=0;$i<count($arr);$i++){
      for($j=1;$j<count($arr[0]);$j++){
        if($arr[$i][$j]<$min){
          $indexi = $i;
          $indexj = $j;
          $min = $arr[$indexi][$indexj];
        }
      }
    }
    return [$min, $indexi, $indexj];
  }

  private function matrixGetVal1($mat, $arr_row, $col){
    $res = array();
    foreach($arr_row as $a){
      $res[] = $mat[$col][$a];
    }
    return $res;
  }

  private function matrixGetVal2($mat, $row, $arr_col){
    $res = array();
    foreach($arr_col as $a){
      $res[] = $mat[$a][$row];
    }
    return $res;
  }

  private function matrixVectorGen($a, $b){
    $res = array();
    if($a <= $b){
      for($i=$a;$i<=$b;$i++)
        $res[] = $i;
    }else{
      for($i=$a;$i>=$b;$i--)
        $res[] = $i;
    }
    return $res;
  }

  private function matrixFindLowEq($mat, $x){
    $row = array();
    $col = array();
    for($i=0;$i<count($mat);$i++){
      for($j=0;$j<count($mat[0]);$j++){
        if($mat[$i][$j] <= $x){
          $row[] = $i;
          $col[] = $j;
        }
      }
    }
    return [$row, $col];
  }

  private function matrix3DimTo1Dim($m){
    $res = array();
    foreach($m as $a){
      foreach($a as $b){
        foreach($b as $c){
          $res[] = $c;
        }
      }
    }
    return $res;
  }

  private function matrix2DimTo1Dim($m){
    $res = array();
    foreach($m as $a){
      foreach($a as $b){
          $res[] = $b;
      }
    }
    return $res;
  }

  private function getSubMatrix3d($mat, $a1, $a2, $b1, $b2, $c1, $c2){
    $res = array();
    $x = 0;
    for($i=$a1;$i<=$a2;$i++){
      $y = 0;
      for($j=$b1;$j<=$b2;$j++){
        $z = 0;
        for($k=$c1;$k<=$c2;$k++){
          $res[$x][$y][$z++] = $mat[$i][$j][$k];
        }
        $y++;
      }
      $x++;
    }
    return $res;
  }

  private function getSubMatrix2d($mat, $a1, $a2, $b1, $b2){
    $res = array();
    $x = 0;
    for($i=$a1;$i<=$a2;$i++){
      $y = 0;
      for($j=$b1;$j<=$b2;$j++){
        $res[$x][$y++] = $mat[$i][$j];
      }
      $x++;
    }
    return $res;
  }

  private function getxcorr2($A, $B){
    $Ans = array();
    if(count($A) == count($B)){
        $Ans = $this->xcorr2((isset($A[0][0][0])?$A[0]:$A),(isset($B[0][0][0])?$B[0]:$B));
        if(isset($A[0][0][0])){
          for($i=1;$i<count($A);$i++){
              $Ans = $this->matrixAdd($Ans, $this->xcorr2($A[$i],(isset($B[0][0][0])?$B[$i]:$B)));
          }
        }
    }else{
        if(!isset($B[0][0][0])){
            $Ans = $this->xcorr2((isset($A[0][0][0])?$A[0]:$A),$B);
            if(isset($A[0][0][0])){
              for($i=1;$i<count($A);$i++){
                  $Ans = $this->matrixAdd($Ans, $this->xcorr2($A[$i],$B));
              }
            }
        }else{
            if(!isset($A[0][0][0])){
                $Ans = $this->getxcorr2($B,$A);
            }else{
                $Ans = $this->xcorr2((isset($A[0][0][0])?$A[0]:$A),(isset($B[0][0][0])?$B[0]:$B));
            }
        }
    }
    return $Ans;
  }

  private function getArrSpec3Dimen($arr, $d3){
    $res = array();
    foreach($arr as $a){
      $temp = [];
      foreach($a as $b){
          $temp[] = $b[$d3-1];
      }
      $res[] = $temp;
    }
    return $res;
  }

  private function matrixAdd($A, $B){
    $res = array();
    for($i=0;$i<count($A);$i++){
      for($j=0;$j<count($A[0]);$j++){
        $res[$i][$j] = $A[$i][$j] + $B[$i][$j];
      }
    }
    return $res;
  }

  private function matrixAddToNum($A, $b){
    foreach($A as &$x){
      foreach($x as &$y){
        $y += $b;
      }
    }
    return $A;
  }

  private function matrixMin2d($A, $B){
    $res = array();
    for($i=0;$i<count($A);$i++){
      for($j=0;$j<count($A[0]);$j++){
        $res[$i][$j] = $A[$i][$j] - $B[$i][$j];
      }
    }
    return $res;
  }

  private function matrixMin3d($A, $B){
    $res = array();
    for($i=0;$i<count($A);$i++){
      for($j=0;$j<count($A[0]);$j++){
        for($k=0;$k<count($A[0][0]);$k++){
          $res[$i][$j][$k] = $A[$i][$j][$k] - $B[$i][$j][$k];
        }
      }
    }
    return $res;
  }

  private function xcorr2($m1, $m2){
    $a = count($m1[0]);
    $b = count($m1);
    $c = count($m2[0]);
    $d = count($m2);
    $res = array();
    for($i=$d*-1+1;$i<$b;$i++){
      $y = $i+$d-1;
      for($j=$c*-1+1;$j<$a;$j++){
        $x = $j+$c-1;
        $res[$y][$x] = 0;
        for($k=0;$k<$d;$k++){
          for($l=0;$l<$c;$l++){
            $res[$y][$x] += (isset($m1[$i+$k][$j+$l])?$m1[$i+$k][$j+$l]:0)*$m2[$k][$l];
          }
        }
      }
    }
    return $res;
  }

  private function pow3dMatrix($imin_matrix){
    foreach($imin_matrix as &$a){
      foreach($a as &$b){
        foreach($b as &$c){
          $c *= $c;
        }
      }
    }
    return $imin_matrix;
  }

  private function pow2dMatrix($imin_matrix){
    foreach($imin_matrix as &$a){
      foreach($a as &$b){
        $b *= $b;
      }
    }
    return $imin_matrix;
  }

  private function pow1dMatrix($imin_matrix){
    foreach($imin_matrix as &$a){
      $a *= $a;
    }
    return $imin_matrix;
  }

  private function matrixSum2d($m){
    $res = array();
    for($i=0;$i<count($m);$i++){
      $temp = 0;
      for($j=0;$j<count($m[0]);$j++){
        $temp += $m[$i][$j];
      }
      $res[] = $temp;
    }
    return $res;
  }

  private function matrixSum1d($m){
    $res = 0;
    foreach($m as $n){
      $res += $n;
    }
    return $res;
  }

  private function gen2DimArrayVal($width, $height, $val){
    $res = array();
    for($i=0;$i<$height;$i++){
      for($j=0;$j<$width;$j++){
        $res[$i][$j] = $val;
      }
    }
    return $res;
  }

  private function gen3DimArrayVal($width, $height, $val){
    $res = array();
    for($i=0;$i<3;$i++){
      for($j=0;$j<$height;$j++){
        for($k=0;$k<$width;$k++){
          $res[$i][$j][$k] = $val;
        }
      }
    }
    return $res;
  }

  private function imgToMatrixRgb($img){
    $x = imagesx($img);
    $y = imagesy($img);
    $res = array();
    for($i=0;$i<$y;$i++){
      for($j=0;$j<$x;$j++){
        $rgb = imagecolorat($img, $i, $j);
        $res[0][$i][$j] = ($rgb >> 16) & 0xFF;
        $res[1][$i][$j] = ($rgb >> 8) & 0xFF;
        $res[2][$i][$j] = $rgb & 0xFF;
      }
    }
    return $res;
  }

  private function getImgSize3d($img){
    return [imagesx($img), imagesy($img), 3];
  }

  private function multMatrix1DimToNum($matrix, $mult){
    foreach($matrix as &$m){
      $m *= $mult;
    }
    return $matrix;
  }

  private function multMatrix2DimToNum($matrix, $mult){
    foreach($matrix as &$m){
      foreach($m as &$n){
        $n *= $mult;
      }
    }
    return $matrix;
  }

  private function multMatrix3DimToNum($matrix, $mult){
    foreach($matrix as &$m){
      foreach($m as &$n){
        foreach($n as &$o){
          $o *= $mult;
        }
      }
    }
    return $matrix;
  }
}
