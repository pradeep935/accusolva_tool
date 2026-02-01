<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Countries;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Client;
use App\Models\Vendor;
use App\Models\Project;
use App\Models\MangeSupplier;
use App\Models\User;

use Redirect, Validator, Session, DB;
use Input, Hash, Response;


class ClientApiDataController extends Controller
{
  public function index(){
    User::pageAccess(20);
    User::clientWiseAccess('show_client_api');

    return view('admin.clientApi.index');
  }

  public function fetchData(Request $request){


    $settings = DB::table('api_settings')->first();

    if(!$settings){
      $data['success'] = false;
      $data['message'] = "Api Setting data was not found";
      return Response::json($data,200,[]);
    }

    $name = $settings->api_name;
    $client_id = $settings->client_id;

    // $check = DB::table('projects')->where('copy_for_client',1)->first();

    // if(!$check){
    //   $data['success'] = false;
    //   $data['message'] = "Please first set a project for copy data";
    //   return Response::json($data,200,[]);
    // }

    if($client_id == 1){

      $clientData = Project::zampilaAllocatedSurvey();
      $clientDataTop = Project::zampilaTopPickSurveys();


      $languages = DB::table('languages')->whereNotNull('LanguageId')->pluck('id','LanguageId')->toArray();
      $countries = DB::table('countries')->whereNotNull('LanguageId')->pluck('id','LanguageId')->toArray();

      if (sizeof($clientDataTop ) > 0) {
        foreach($clientDataTop as $client){

          if($client){
            $flag = DB::table('projects')->where('surveyId',$client['SurveyId'] )->first();
            if(!$flag){
              $project =  new Project();

              $project->surveyId = $client['SurveyId'];
              $project->project_name = $client['Name'];
              $project->req_complete = $client['TotalCompleteRequired'];
              $project->loi = $client['LOI'];
              $project->ir = $client['IR'];
              $project->language_id = isset($languages[$client['LanguageId']]) ? $languages[$client['LanguageId']] : 0;
              $project->country_id = isset($countries[$client['LanguageId']]) ? $countries[$client['LanguageId']] : 0;
              $project->cpc = $client['CPI'];
              $surveyId = $client['SurveyId'];

              $project->parent_project_id = 0;
              $project->study_type = 5;
              $project->currency_id = 161;
              $project->top_survey = 1;
              
              $project->survey_link = "https://surveysupply.zamplia.com/api/v1/Surveys/GenerateLink". "?SurveyId={$surveyId}". "&IpAddress={{ip}}". "&TransactionId={{txn}}";
              
              $project->survey_test_link = "";
              
              $project->client_id = 13;
              $project->project_manager_id = 16;
              $project->sales_manager_id = 15;
              $project->start_date = date("Y-m-d");
              $project->notes = "NA";
              $project->project_brief = "NA";
              $project->status = 3; 
              $project->client_api_data = 1; 
              $project->save();
            }
          }
        }  
      }

      if (sizeof($clientData ) > 0) {
        foreach($clientData as $client){

          if($client){
            $flag = DB::table('projects')->where('surveyId',$client['SurveyId'] )->first();
            if(!$flag){
              $project =  new Project();

              $project->surveyId = $client['SurveyId'];
              $project->project_name = $client['Name'];
              $project->req_complete = $client['TotalCompleteRequired'];
              $project->loi = $client['LOI'];
              $project->ir = $client['IR'];
              $project->language_id = isset($languages[$client['LanguageId']]) ? $languages[$client['LanguageId']] : 0;
              $project->country_id = isset($countries[$client['LanguageId']]) ? $countries[$client['LanguageId']] : 0;
              $project->cpc = $client['CPI'];
              $surveyId = $client['SurveyId'];

              $project->parent_project_id = 0;
              $project->study_type = 5;
              $project->currency_id = 161;
              
              $project->survey_link = "https://surveysupply.zamplia.com/api/v1/Surveys/GenerateLink". "?SurveyId={$surveyId}". "&IpAddress={{ip}}". "&TransactionId={{txn}}";
              
              $project->survey_test_link = "";
              
              $project->client_id = 13;
              $project->project_manager_id = 16;
              $project->sales_manager_id = 15;
              $project->start_date = date("Y-m-d");
              $project->notes = "NA";
              $project->project_brief = "NA";
              $project->status = 3; 
              $project->client_api_data = 1; 
              $project->save();
            }
          }
        }  
      }

      
    }

    $data['success'] = true;
    $data['message'] = "Data was successfuly fetched";
    return Response::json($data,200,[]);
  }

  public function init(Request $request){

    $showStatusOptions = Project::showStatusOptions();
    $page_no = $request->page_no;
    $max_per_page = $request->max_per_page;

    $projects = DB::table('projects')->select('projects.*','clients.clientName','users.user_name as project_manager','users_sale.user_name as salesManagers','countries.name as country_name')
    ->leftjoin("clients","clients.id","=","projects.client_id")
    ->leftjoin("users","users.id","=","projects.project_manager_id")
    ->leftjoin("countries","countries.id","=","projects.country_id")
    ->leftjoin("users as users_sale","users_sale.id","=","projects.sales_manager_id")
    ->where('client_api_data',1);

    $total = $projects->count();

    $projects = $projects->skip(($page_no-1)*$max_per_page)->take($max_per_page)->orderBy('top_survey',"DESC")->orderBy('projects.id','DESC')->get();

    foreach ($projects as $project) {
      $project->start_date_created = date('d-m-Y', strtotime($project->created_at));
      $project->status_id = $project->status;
      $project->status = $showStatusOptions[$project->status];
    }

    $data['success'] = true;
    $data['clientData'] = $projects;
    $data['total'] = $total;
    return Response::json($data,200,[]);

  }

  public function setting(Request $request){
    return view('admin.setting.index');
  }

  public function deleteProject($project_id){
    DB::table('projects')->where('id',$project_id)->delete();
    $data['success'] = true;
    $data["message"] ="Project is successfuly deleted";
    return Response::json($data,200,[]);
  }

  public function allSettings(){
    $data['countries'] = DB::table('countries')->select('id','name')->get();
    $data['success'] = true;
    return Response::json($data,200,[]);
  }

  public function saveAPISettings(Request $request){
    DB::table('api_settings')->delete();

    DB::table('api_settings')->insert([
      "api_name" => $request->api_name,
      "client_id" => $request->client_id,
    ]);

    $data['message'] = "Settings was successfuly changed";
    $data['success'] = true;
    return Response::json($data,200,[]);
  }

  public function getClients(Request $request){
    $clients = DB::table('client_api_data_settings')->get();

    $data['clients'] = $clients;
    $data['success'] = true;
    return Response::json($data,200,[]);
  }

  public function clientWiseCountry(Request $request){
    $settings = DB::table('api_settings')->first();
    $client_id = $settings->client_id;
    $countries = DB::table('countries')->where('client_id',$client_id)->get();
    $data['countries'] = $countries;
    $data['success'] = true;
    return Response::json($data,200,[]);
  }

  public function getCountry(Request $request){

    $settings = DB::table('api_settings')->first();
    $client_id = $settings->client_id;
    $name = $settings->api_name;
    $clientData = Project::curl_fnt_country_data($name);
    $countryData = json_decode($clientData, true);

    if($countryData){
      foreach($countryData['data'] as $country){
        $check = DB::table('countries')->where('countryID',$country['countryID'])->first();
        if(!$check){
          DB::table('countries')->insert([
            "name" => $country['countryName'],
            "nameCode" => $country['countryCode'],
            "client_id" => $client_id,
            "countryID" => $country['countryID']
          ]);
        }
      }
    }

    $countries = DB::table('countries')->where('client_id',$client_id)->get();

    $data['countries'] = $countries;
    $data['success'] = true;
    return Response::json($data,200,[]);
  }

  public function operation(Request $request){
    $project_ids = $request->project_ids;
    $type = $request->type;
    if($type == 1){ // delete
      DB::table('projects')->whereIn('id',$project_ids)->delete();
      $message = "Data is successfuly deleted";
    }

    if($type == 2){ // Approved
      DB::table('projects')->whereIn('id',$project_ids)->update(["approved" => 1]);
      $message = "Data is successfuly Approved";
    }

    if($type == 3){ // disapproved
      DB::table('projects')->whereIn('id',$project_ids)->update(["approved" => 0]);
      $message = "Data is successfuly Disapproved";
    }
    $data['message'] = $message;
    $data['success'] = true;
    return Response::json($data,200,[]);
  }

}
