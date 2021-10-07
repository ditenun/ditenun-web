<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
  /**
   * Create a new controller instance
   *
   * @return void
  **/
  // public function __construct()
  // {
  //         $this->middleware('auth');
  // }

  public function viewAll(){
    $data = Faq::orderBy('id')->get();

    if ($data) {
      return response()->json([
        'success' => true,
        'message' => 'Data Found!',
        'data' => $data
      ], 200);
    } else {
      return response()->json([
        'success' => true,
        'message' => 'Data Not Found!',
        'data' => ''
      ], 400);
    }
  }

  public function view($id){
    $data = Faq::find($id);

    if ($data) {
      return response()->json([
        'success' => true,
        'message' => 'Data Found!',
        'data' => $data
      ], 200);
    } else {
      return response()->json([
        'success' => true,
        'message' => 'Data Not Found!',
        'data' => ''
      ], 400);
    }
  }

  public function post(Request $request){
    $judul = $request->input('judul');
    $deskripsi = $request->input('deskripsi');

    $post = Faq::create([
      'judul' => $judul,
      'deskripsi' => $deskripsi,
    ]);

    if ($post) {
      return response()->json([
        'succes' => true,
        'message' => 'Posting Success!',
        'data' => $post,
      ], 201);
    } else {
      return response()->json([
        'succes' => false,
        'message' => 'Posting Fail!',
        'data' => ''
      ], 400);
    }
  }

  public function update($id, Request $request){
    $judul = $request->input('judul');
    $deskripsi = $request->input('deskripsi');

    $update = Faq::where('id', $id)->first();
    if (!empty($judul)) {
      $update->judul = $judul;
    }
    if (!empty($deskripsi)) {
      $update->deskripsi = $deskripsi;
    }

    if ($update) {
      if ($update->save()) {
        return response()->json([
        'succes' => true,
        'message' => 'Update Success!',
        'data' => $update,
      ], 201);
      }
    } else {
      return response()->json([
        'succes' => false,
        'message' => 'Update Fail!',
        'data' => ''
      ], 400);
    }
  }
}
