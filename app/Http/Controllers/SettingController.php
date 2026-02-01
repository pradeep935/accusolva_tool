<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Redirect, Validator, Session, DB;
use Input, Hash, Response;


class SettingController extends Controller
{
    public function index(){
        return view('admin.setting.index');
    }

    public function uploadFile(Request $request){
        $destination = 'uploads/';
        
        if($request->media){
            $file = $request->media;
            $extension = $request->media->getClientOriginalExtension();
            $name = strtotime("now").'.'.strtolower($extension);
            $file = $file->move($destination, $name);
            $data["media"] = $destination.$name;

            $data["success"] = true;
            $data["media_link"] = url($destination.$name);
            
        }else{
            $data['success'] = false;
            $data['message'] ='file not found';
        }

        return Response::json($data, 200, array());
    }

    public function store(Request $request){

        $params = User::settingParams();

        foreach ($params as $param) {
            $paramValue = $request->{$param};
            DB::table('settings')->where('param',$param)->update(['value' => $paramValue]);
        }

        $data['success'] = true;
        $data['message'] ='Record is successfully submitted';
        return Response::json($data, 200, array());

    }

    public function init(Request $request){

        $settings = DB::table('settings')->get();
        
        $data['success'] = true;
        $data['settings'] = $settings;
        return Response::json($data, 200, array());

    }

}












