<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Countries, App\Models\Currency, App\Models\Language, App\Models\Client, App\Models\Vendor, App\Models\Project, App\Models\User;
use Redirect, Validator, Session, DB, stdClass, Input, Hash, Response;

class ExportDashboardController extends Controller
{

    public function index(){
        $vendors = DB::table('vendors')->pluck('vendorName','id')->toArray();
        $clients = DB::table('clients')->pluck('clientName','id')->toArray();
        $project_status = Project::showStatusOptions();
        $status = Project::StatusOptions();
        $surveyInformations = [];

        return view('admin.export.index',["vendors" => $vendors,"clients" => $clients, "project_status" => $project_status, 'status' => $status, 'surveyInformations' => $surveyInformations]);
    }

    public function getProject(){
        $term = Input::get('term');
        $term = str_replace(" ","%",$term);
        $companies = DB::table('projects')->select('id','project_name as label')->where('project_name','LIKE',$term.'%')->take(30)->get();

        return $companies;
    }

    public function ExportBulk(Request $request){

        $project_id = $request->project_id;
        $vendor_id = $request->vendor_id;
        $client_id = $request->client_id;
        $from_date = $request->from_date ? date("Y-m-d",strtotime($request->from_date)) : null;
        $to_date = $request->to_date ? date("Y-m-d",strtotime($request->to_date)) : null;
        $project_status_id = $request->project_status_id;
        $status_id = $request->status_id;

        $StatusOptions = Project::StatusOptions();
        $countries = DB::table('countries')->pluck('name','id')->toArray();
        $client_countries = DB::table('countries')->pluck('name','countryID')->toArray();

        $surveyInformations = DB::table('start_survey_informations')->select('start_survey_informations.*','projects.project_name','projects.client_api_data','projects.country_id','vendors.vendorName','clients.clientName')
        ->leftjoin('projects','projects.id','=','start_survey_informations.pid')
        ->leftjoin('vendors','vendors.id','=','start_survey_informations.vendor_id')
        ->leftjoin('clients','clients.id','=','projects.client_id');

        if($project_id){
            $surveyInformations = $surveyInformations->where('start_survey_informations.pid',$request->project_id);
        }

        if($status_id){
            $surveyInformations = $surveyInformations->where('start_survey_informations.status',$status_id);
        }

        if($vendor_id){
            $surveyInformations = $surveyInformations->where('start_survey_informations.vendor_id',$vendor_id);
        }

        if($client_id){
            $surveyInformations = $surveyInformations->where('projects.client_id',$client_id);
        }

        if($status_id){
            $surveyInformations = $surveyInformations->where('start_survey_informations.status',$status_id);
        }

        if($from_date){
            $surveyInformations = $surveyInformations->where('start_survey_informations.date','>=',$from_date);
        }

        if($to_date){
            $surveyInformations = $surveyInformations->where('start_survey_informations.date','<=',$to_date);
        }


        $surveyInformations = $surveyInformations->orderBy('start_survey_informations.id','DESC')->get();

        foreach ($surveyInformations as $surveyInformation) {

            if($surveyInformation->client_api_data == 1){
                $surveyInformation->country_name = $client_countries[$surveyInformation->country_id];
            }else{
                $surveyInformation->country_name = $countries[$surveyInformation->country_id];
            }

            $surveyInformation->start_date = User::convertDateShow($surveyInformation->start_time);
            $surveyInformation->end_date = User::convertDateShow($surveyInformation->end_time);
            $surveyInformation->start_time = $surveyInformation->start_time ? date("H:i:s",strtotime($surveyInformation->start_time)) : null;
            $surveyInformation->end_time = $surveyInformation->end_time ? date("H:i:s",strtotime($surveyInformation->end_time)) : null;

            $surveyInformation->status = $StatusOptions[$surveyInformation->status];

            $interval = strtotime($surveyInformation->end_time)-(strtotime($surveyInformation->start_time));

            $h = floor($interval / 3600);
            $m = floor(($interval % 3600) / 60);
            $s = $interval % 60;
            $surveyInformation->loi = sprintf("%02d:%02d:%02d", $h, $m, $s);

        }

        include(app_path()."/ExcelExport/bulk_survey_detail.php");


    }
}
