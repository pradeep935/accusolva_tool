<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Input, Redirect, Validator, Hash, Response, Session, DB;
use Http;
use App\Models\User, App\Models\Notification, App\Models\MailQueue, App\Models\Utilities;

use App\Http\Controllers\ExportController, Crypt;

class UserController extends Controller {

	public function login(){
        $logo = User::getSettingParams('large_image');
        $background = User::getSettingParams('login_image');
        $fevico_image = User::getSettingParams('fevico_image');
		return view('front-end.login',["logo" => $logo->value,"background" => $background->value,"fevico_image" => $fevico_image->value]);
	}  


    public function signup(){
        return view('front-end.sign_up');
    }  

	public function postLogin(Request $request){

		$cre = [
            "email"=>$request->email,
            "password"=>$request->password,
        ];
   
        $rules = ["email"=>"required","password"=>"required"];

        $messages=[
            "email.required" => "Please fill email",
            "password.required" => "Please fill password",
        ];

		$validator = Validator::make($cre,$rules,$messages);

		if($validator->passes()){

            if( Auth::attempt($cre) ){


                $role_access = DB::table('roles')->where('id',Auth::user()->role_id)->first();

                    if( !$role_access ){
                        Auth::logout();
                        return Redirect::to('/')->withInput()->with('failure','The role is disabled.');
                    }

                $role_access = DB::table('client_user_priv')->where('user_type_id',Auth::user()->role_id)->first();

                $accessRights = explode(",", $role_access->access_right_id);
                
                Session::put('access',$accessRights);





                return Redirect::to('dashboard');
			} else {
                return Redirect::back()->withInput()->with('failure','Invalid email or password');
			}

		}else{
            return Redirect::back()->withErrors($validator)->withInput();
		}
	}


    public function forgetPassword(){
        return view('front-end.forget_password');
    }

    public function postForgetPassword(Request $request){
        $validator = Validator::make(["email"=>$request->email],["email"=>"required"]);
        
        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput()->with('failure','Please enter email id');
        }
        
        $user = User::where('email',$request->email)->first();
        
        if(!$user){
            return Redirect::back()->withErrors($validator)->withInput()->with('failure','No user found with this email id');
        }

        $rand_pwd = User::getRandPassword();
        
        $user->password = Hash::make($rand_pwd);
        $user->check_password = $rand_pwd;
        $user->save();
        $user->sendForgetPasswordEmail($rand_pwd);


        return Redirect::to('/login')->with('success','New password has been sent to your registered email id');
    }

    public function profile(){
        $sidebar = "profile";
        $subsidebar = "profile";


        return view('admin.profile',compact('sidebar','subsidebar'));
    }

    public function updatePassword(Request $request){
        $cre = [
            "old_password"=>$request->old_password,
            "new_password"=>$request->new_password,
            "confirm_password"=>$request->confirm_password
        ];
        $rules = [
            "old_password"=>'required',
            "new_password"=>'required|min:5',
            "confirm_password"=>'required|same:new_password'
        ];
        $old_password = Hash::make($request->old_password);
        $validator = Validator::make($cre,$rules);
        if ($validator->passes()) { 
            if (Hash::check($request->old_password, Auth::user()->password )) {

                if ($request->new_password != Auth::user()->password_check ) {
                    $password = Hash::make($request->new_password);
                    $user = User::find(Auth::id());
                    $user->password = $password;
                    $user->check_password = $request->new_password;
                    $user->save();

                    return Redirect::back()->with('success', 'Password changed successfully ');
                }else{
                    return Redirect::back()->withInput()->with('failure', 'New password must be different from the current password.');
                }
                
            } else {
                return Redirect::back()->withInput()->with('failure', 'Old password does not match.');
            }
        } else {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        return Redirect::back()->withErrors($validator)->withInput()->with('failure','Unauthorised Access or Invalid Password');
    }

    public function language(){

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'ZAMP-KEY' => 'b9ZJiXDgbvrRwEoJJaFcWDVqAKmMStDF',
        ])->get('https://surveysupply.zamplia.com/api/v1/Attributes/GetLanguages');

        $data = $response->json();

        if ($data['success'] && isset($data['result']['data'])) {
            $languages = $data['result']['data'];
        } else {
            return [];
        }
    
        foreach ($languages as $language) {
            $test = DB::table('languages_data')->where('LanguageId',$language['LanguageId'])->first();
            if(!$test){
                DB::table('languages_data')->insert([
                    "LanguageId" => $language['LanguageId'],
                    "LanguageCode" => $language['LanguageCode'],
                    "Country" => $language['Country'],
                    "CountryCode" => $language['CountryCode'],
                ]);
            }
        }


        $records = DB::table('languages_data')->get();

        foreach ($records as $record) {
            $l = DB::table('languages')->where("LanguageId",$record->LanguageId)->first();
            if(!$l){
                DB::table('languages')->insert([
                    "LanguageId" => $record->LanguageId,
                    "language_code" => $record->LanguageCode,
                    "language_name" => $record->Country,
                ]);
            }
            
            $c = DB::table('countries')->where("LanguageId",$record->LanguageId)->first();
            if(!$c){
                DB::table('countries')->insert([
                    "LanguageId" => $record->LanguageId,
                    "nameCode" => $record->LanguageCode,
                    "name" => $record->Country,
                ]);
            }
        }
    }


    
}
