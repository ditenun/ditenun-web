<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

trait RESTActions {

    public function all(Request $request){
        $m = self::MODEL;
        $data = $m::all();
        $rest['success'] = true;
        $rest['method'] = $request->method();
        $rest['uri'] = $request->fullUrl();
        $rest['message'] = $data;
        return $this->respond(Response::HTTP_OK, $rest);
    }

    public function get(Request $request, $id){
        $m = self::MODEL;
        $data = $m::find($id);
        if(is_null($data)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $rest['success'] = true;
        $rest['method'] = $request->method();
        $rest['uri'] = $request->fullUrl();
        $rest['message'] = $data;
        return $this->respond(Response::HTTP_OK, $rest);
    }

    public function add(Request $request){
        $m = self::MODEL;
        $this->validate($request, $m::$rules);
        return $this->respond(Response::HTTP_CREATED, $m::create($request->all()));
    }

    public function put(Request $request, $id){
        $m = self::MODEL;
        $this->validate($request, $m::$rules);
        $model = $m::find($id);
        if(is_null($model)){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $model->update($request->all());
        return $this->respond(Response::HTTP_OK, $model);
    }

    public function remove($id){
        $m = self::MODEL;
        if(is_null($m::find($id))){
            return $this->respond(Response::HTTP_NOT_FOUND);
        }
        $m::destroy($id);
        return $this->respond(Response::HTTP_NO_CONTENT);
    }
  	
}
