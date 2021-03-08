<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedBack;

class FeedbackController extends Controller
{
	/**
	 * Create a new controller instance
	 *
	 * @return void
	**/
	// public function __construct()
	// {
	// 	$this->middleware('auth');
	// }

	public function viewAll(){
		$data = FeedBack::orderBy('id')->get();

		if ($data) {
			return response()->json([
					'success' => true,
					'message' => 'Data Found!',
					'data' => [$data]
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
		$data = FeedBack::find($id);

		if ($data) {
			return response()->json([
				'success' => true,
				'message' => 'Data Found!',
				'data' => [$data]
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
		$subjek = $request->input('subjek');
		$deskripsi = $request->input('deskripsi');
		$rating = $request->input('rating');
		$user_id = $request->input('user_id');

		$post = FeedBack::create([
			'subjek' => $subjek,
			'deskripsi' => $deskripsi,
			'rating' => $rating,
			'user_id' => $user_id,
		]);

		if ($post) {
			return response()->json([
				'succes' => true,
				'message' => 'Posting Success!',
				'data' => [$post],
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
		$subjek = $request->input('subjek');
		$deskripsi = $request->input('deskripsi');
		$rating = $request->input('rating');

		$update = FeedBack::where('id', $id)->first();
		if (!empty($subjek)) {
			$update->subjek = $subjek;
		}
		if (!empty($deskripsi)) {
			$update->deskripsi = $deskripsi;
		}
		if (!empty($rating)) {
			$update->rating = $rating;
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
