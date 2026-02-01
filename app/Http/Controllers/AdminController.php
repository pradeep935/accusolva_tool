<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth, App\Models\Proxy, App\Models\Approval;
use Illuminate\Support\Facades\Agent;
use Illuminate\Http\Request;
use App\Models\Countries, App\Models\Currency, App\Models\User, App\Models\Language, App\Models\Client, App\Models\Vendor, App\Models\Project;
use DB, Response, Session, Redirect, Hash;

class AdminController extends Controller {



    public function dashboard(){
        $sidebar = 'dashboard';
        $subsidebar = 'dashboard';

        return view('admin.dashboard', [
            "sidebar" => "dashboard",
            "subsidebar" => "dashboard"
        ]);
    }

    public function approveUser ($user_approval_id){

        $user_approval = DB::table('user_approvals')->where("id",$user_approval_id)->first();

        $code = User::getRandPassword();
        $password = User::getRandPassword();

        $user = new User;
        $user->code = $code;
        $user->first_name = $user_approval->first_name;
        $user->last_name = $user_approval->last_name;
        $user->user_name = $user_approval->user_name;
        $user->email = $user_approval->email;

        $user->password = Hash::make($password);
        $user->check_password = $password;
        
        $user->wallet_balance = 0;
        $user->parent_id = $user_approval->parent_id;
        $user->save();

        $user->sendWelcomeEmail($password);


        DB::table('user_approvals')->where("id",$user_approval_id)->update(array(
            "status" => 1
        ));

        return Redirect::back()->with("success","Request is successfully approved");
    }

    public function rejectUser ($user_approval_id){

        DB::table('user_approvals')->where("id",$user_approval_id)->update(array(
            "status" => 2
        ));

        return Redirect::back()->with("success","Request is successfully rejected");

    }

    public function dashboardInit(Request $request){

        $today = date("Y-m-d");
        $countries = DB::table('countries')->pluck('name','id')->toArray();
        $client_countries = DB::table('countries')->pluck('name','countryID')->toArray();

        $surveyInformations = DB::table('start_survey_informations')->select('start_survey_informations.*','projects.project_name','projects.client_api_data','projects.country_id','vendors.vendorName','clients.clientName')
        ->leftjoin('projects','projects.id','=','start_survey_informations.pid')
        ->leftjoin('vendors','vendors.id','=','start_survey_informations.vendor_id')
        ->leftjoin('clients','clients.id','=','projects.client_id')
        ->where('start_survey_informations.date',$today)
        ->orderBy('start_survey_informations.id','DESC')
        ->get();

        $StatusOptions = Project::StatusOptions();

        foreach ($surveyInformations as $surveyInformation) {


            if($surveyInformation->client_api_data == 1){
                $surveyInformation->country_name = isset($client_countries[$surveyInformation->country_id]) ? $client_countries[$surveyInformation->country_id] : null;
            }else{
                $surveyInformation->country_name = isset($countries[$surveyInformation->country_id]) ? $countries[$surveyInformation->country_id] : null;
            }

            $surveyInformation->start_date = User::convertDateShow($surveyInformation->start_time);
            $surveyInformation->end_date = User::convertDateShow($surveyInformation->end_time);
            $surveyInformation->start_time = $surveyInformation->start_time ? date("H:i:s",strtotime($surveyInformation->start_time)) : null;
            $surveyInformation->end_time = $surveyInformation->end_time ? date("H:i:s",strtotime($surveyInformation->end_time)) : null;

            $surveyInformation->showStatus = $StatusOptions[$surveyInformation->status];
        }

        $data['success'] = true;
        $data["surveyInformations"] = $surveyInformations;
        return Response::json($data,200,[]);

    }

    public function dashboardMonthlyStastics(Request $request){

        $currentDate = date('Y-m-d');

        $startDate = date('Y-m-01', strtotime($currentDate));
        $endDate = date('Y-m-t', strtotime($currentDate));

        $monthlyStastics = DB::table('start_survey_informations')->select('start_survey_informations.*','projects.project_name','vendors.vendorName','clients.clientName','countries.name as country_name')
        ->leftjoin('projects','projects.id','=','start_survey_informations.pid')
        ->leftjoin('vendors','vendors.id','=','start_survey_informations.gid')
        ->leftjoin('clients','clients.id','=','projects.client_id')
        ->leftjoin('countries','countries.id','=','projects.country_id')
        ->whereBetween('date',[$startDate,$endDate])
        ->orderBy('start_survey_informations.id','DESC')
        ->get();

        $StatusOptions = Project::StatusOptions();

        foreach ($monthlyStastics as $monthlyStastic) {
            $monthlyStastic->start_date = User::convertDateShow($monthlyStastic->start_time);
            $monthlyStastic->end_date = User::convertDateShow($monthlyStastic->end_time);
            $monthlyStastic->start_time = $monthlyStastic->start_time ? date("H:i:s",strtotime($monthlyStastic->start_time)) : null;
            $monthlyStastic->end_time = $monthlyStastic->end_time ? date("H:i:s",strtotime($monthlyStastic->end_time)) : null;

            $monthlyStastic->showStatus = $StatusOptions[$monthlyStastic->status];
        }

        $data['success'] = true;
        $data["monthlyStastics"] = $monthlyStastics;
        return Response::json($data,200,[]);

    }

    public function dashboardProjectStatusInit(Request $request){

        $projectStatus = DB::table('projects')
        ->select('projects.*','clients.clientName','users.user_name as project_manager','users_sale.user_name as salesManagers')
        ->leftjoin("clients","clients.id","=","projects.client_id")
        ->leftjoin("users","users.id","=","projects.project_manager_id")
        ->leftjoin("users as users_sale","users_sale.id","=","projects.sales_manager_id")
        ->orderBy('projects.id','DESC')
        ->where('client_api_data',0)
        ->whereNot('copy_for_client',1)
        ->orWhere('approved',1)
        ->get();


        foreach ($projectStatus as $status) {
        }

        $data['success'] = true;
        $data["projectStatus"] = $projectStatus;
        return Response::json($data,200,[]);

    }

    public function accessRights(Request $request){
        User::pageAccess(21);
        $user_types = DB::table('roles')->get();
        $access_rights = DB::table('access_rights')->select("id","access_rights as access")->get();
        $client_user_priv = DB::table('client_user_priv')
        ->select('user_type_id','access_right_id')->get();
        foreach ($user_types as $userTypes) {
            $access_right_id = [];
            foreach ($client_user_priv as $user_priv) {
                if($userTypes->id == $user_priv->user_type_id){
                    $access_right_id = explode(',', $user_priv->access_right_id);

                }

            }
            $userTypes->access_right_id = $access_right_id;
        }
        return view('admin.role_manager.index',['user_types'=> $user_types,'access_rights'=>$access_rights]);
    }


    public function saveAccess(Request $request){

        $client_user_priv = DB::table('client_user_priv')->delete();
        $user_types = DB::table('roles')->get();

        foreach ($user_types as $value) {
            $data = $request->get('access_'.$value->id);
            if($data){
                $access_right = implode(',', $data);
                DB::table('client_user_priv')->insert([
                    "user_type_id" => $value->id,
                    "access_right_id" => $access_right,
                ]);
            }

        }
        return Redirect::back();
    }

    public function dailyStatsExport(Request $request){
        $dailyStats = $request->all();
        include(app_path()."/ExcelExport/daily_survey_detail.php");
        $data["excel_link"] = url('uploads/'.$filename);
        $data['success'] = true;
        return Response::json($data,200,[]);
    }

    
}
