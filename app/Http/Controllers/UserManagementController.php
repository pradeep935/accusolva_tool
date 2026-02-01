<?php

namespace App\Http\Controllers;

 

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Input, Redirect, Validator, Hash, Response, Session;
use App\Models\MailQueue, DB, App\Models\Portfolio, App\Models\Proxy, App\Models\Setting, App\Models\Utilities, App\Models\User;

class UserManagementController extends Controller {

    public function index(){
        User::pageAccess(10);
        $accessRights = Session::get("access");
        return view('admin.users.index',["accessRights" => $accessRights]);
    }

    public function init(Request $request){
        $page_no = $request->page_no;
        $max_per_page = $request->max_per_page;

        $users = DB::table('users')->select('users.*');
        
        $total = $users->count();

        if($request->user_name){
            $users = $users->where('user_name', 'LIKE' ,'%'.$request->user_name.'%');
        }

        if($request->mobile){
            $users = $users->where('mobile', 'LIKE' ,'%'.$request->mobile.'%');
        }

        if($request->email){
            $users = $users->where('email', 'LIKE' ,'%'.$request->email.'%');
        }

        
        $users = $users->skip(($page_no-1)*$max_per_page)->take($max_per_page)->whereNot('role_id',1)->get();

        $user_roles = DB::table('roles')->select("id","name")->pluck("name","id")->toArray();


        foreach($users as $user){
            $user->role = $user_roles[$user->role_id];
        }


        $user_roles = DB::table('roles')->get();


        $data['total'] = $total;


        $data['success'] = true;
        $data['users'] = $users;
        $data['user_roles'] = $user_roles;

        return Response::json($data,200,[]);
    }



    public function saveUser(Request $request){
        $cre = [
            "user_name" => $request->user_name,
            "mobile" => $request->mobile,
            "email" => $request->email,
            "check_password" => $request->check_password,


        ];
        $validator = Validator::make($cre, [
            "user_name" => "required",
            "mobile" => "required",
            "email" => "required|email|unique:users,email,".$request->id,
            "check_password" => "required"
        ]);

        if ($validator->passes()) {

            if($request->id) {

                DB::table("users")->where("id",$request->id)->update(array(
                    "user_name" => $request->user_name,
                    "mobile" => $request->mobile,
                    "email" => $request->email,
                     "role_id" => $request->role_id,
                    "password" =>  Hash::make($request->check_password),
                    "check_password" => $request->check_password,


                ));

                $data["success"] = true;
                $data["message"] = "User Data is successfully Updated";

            }else{
                

                DB::table("users")->insert(array(
                    "user_name" => $request->user_name,
                    "mobile" => $request->mobile,
                    "email" => $request->email,
                    "password" =>  Hash::make($request->check_password),
                    "check_password" => $request->check_password,
                    "added_by" => Auth::user()->id,
                    "role_id" => $request->role_id,
                    "created_at" => date('Y-m-d H:i:s')

                ));
                

                $data["success"] = true;
                $data["message"] = "User Data is successfully saved";

            }

        } else {
            $data["success"] = false;
            $data["message"] = $validator->errors()->first();
        }

        return Response::json($data, 200 ,[]);
    }

    public function removeUser($user_id){
        User::pageAccess(9);
        DB::table('users')->where('id',$user_id)->delete();

        $data["success"] = true;
        $data["message"] = "User is Deleted Successfully";

        return Response::json($data, 200 ,[]);


    }



 

  
    
}