<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Countries, App\Models\Currency, App\Models\Language, App\Models\Client, App\Models\Vendor, App\Models\Project, App\Models\User;
use Redirect, Validator, Session, DB, stdClass, Input, Hash, Response;

class ProjectController extends Controller
{
    
    public function getContactPerson($clientId){
        $client = Client::find($clientId);
        if (!$client) {
            return response()->json([]);
        }
        return response()->json($client->contactPerson);
    }

    public function index(){
        User::pageAccess(6);
        $accessRights = Session::get("access");
        return view('admin.projects.index',["accessRights" => $accessRights]);
    }

    public function copyProject(Request $request){
        $check = DB::table('projects')->update(["copy_for_client" => 0]);

        $check = DB::table('projects')->where('id',$request->project_id)->first();
        $project =  new Project();
        $project->project_name = $check->project_name;
        $project->parent_project_id = $check->parent_project_id;
        $project->study_type = $check->study_type;
        $project->country_id = $check->country_id;
        $project->language_id = $check->language_id;
        $project->currency_id = $check->currency_id;
        $project->cpc = $check->cpc;
        $project->survey_link = $check->survey_link;
        $project->survey_test_link = $check->survey_test_link;
        $project->req_complete = $check->req_complete;
        $project->loi = $check->loi;
        $project->ir = $check->ir;
        $project->client_id = $check->client_id;
        $project->project_manager_id = $check->project_manager_id;
        $project->sales_manager_id = $check->sales_manager_id;
        $project->start_date = date("Y-m-d");
        $project->notes = $check->notes;
        $project->project_brief = $check->project_brief;
        $project->status = $check->status; 
        $project->copy_for_client = 1; 
        $project->save();

        $data['success'] = true;
        return Response::json($data,200,[]);
    }

    public function indexInit(Request $request){

        $page_no = $request->page_no;
        $max_per_page = $request->max_per_page;
        $showCopy = false;
        $showStatusOptions = Project::showStatusOptions();
        // $showCopyData = DB::table('settings')->where('param','showCopy')->where('value',1)->first();

        // if($showCopyData){
        //     $showCopy = true;
        // }   

        $countries = DB::table('countries')->pluck('name','id')->toArray();
        $client_countries = DB::table('countries')->pluck('name','countryID')->toArray();


        $projects = DB::table('projects')->select('projects.*','clients.clientName','users.user_name as project_manager','users_sale.user_name as salesManagers')
        ->leftJoin("clients", "clients.id", "=", "projects.client_id")
        ->leftJoin("users", "users.id", "=", "projects.project_manager_id")
        ->leftJoin("users as users_sale", "users_sale.id", "=", "projects.sales_manager_id")
        ->where(function($q) {
            $q->where('client_api_data', 0)
            ->where('copy_for_client', '!=', 1)
            ->orWhere('approved', 1);
        });

        if($request->id){
            $projects = $projects->where('projects.id',$request->id);
        }
        if($request->parent_project_id){
            $projects = $projects->where('projects.id',$request->parent_project_id);
        }
        if($request->project_name){
            $projects = $projects->where('project_name', 'LIKE' ,'%'.$request->project_name.'%');
        }
        if($request->status){
            $projects = $projects->where('projects.status', $request->status);
        }


        if($request->client_id){
            $projects = $projects->where('client_id',$request->client_id);
        }
        if($request->project_manager_id){
            $projects = $projects->where('project_manager_id',$request->project_manager_id);
        }

        if($request->country_id){
            $projects = $projects->where('country_id',$request->country_id);
        }
        if($request->sales_manager_id){
            $projects = $projects->where('sales_manager_id',$request->sales_manager_id);
        }

        // if(!$showCopyData){
        //     $projects = $projects->where('copy_for_client',0);
        // }
        $total = $projects->count();

        $projects = $projects->skip(($page_no-1)*$max_per_page)->take($max_per_page)->orderBy('projects.copy_for_client','DESC')->orderBy('projects.id','DESC')->get();

        $projectIds = [];
        foreach ($projects as $project) {
            if($project->client_api_data == 1){
                $project->country_name = isset($countries[$project->country_id]) ? $countries[$project->country_id] : null;
            }else{
                $project->country_name = isset($countries[$project->country_id]) ? $countries[$project->country_id] : null;
            }
            $projectIds[] = $project->id;
            $project->start_date_created = date('d-m-Y', strtotime($project->created_at));
            $project->status_id = $project->status;
            $project->status = $showStatusOptions[$project->status];
        }

        $surveyInformations = DB::table('start_survey_informations')->whereIn('pid',$projectIds)->get();

        foreach($projects as $project){
            $project->hits = 0;
            $project->complete = 0;
            $project->disqualify = 0;
            $project->quota_full = 0;
            $project->securityTerm = 0;
            $project->drop = 0;
            $project->showCopy = $showCopy;

            foreach ($surveyInformations as $surveyInformation) {
                if($project->id == $surveyInformation->pid){
                    $project->hits++;
                    if($surveyInformation->status == 1) $project->complete++;
                    if($surveyInformation->status == 2) $project->disqualify++;
                    if($surveyInformation->status == 3) $project->quota_full++;
                    if($surveyInformation->status == 4) $project->securityTerm++; 
                    if($surveyInformation->status == 0) $project->drop++; 
                }
                $project->abendond =  number_format((($project->hits - $project->drop)*100)/($project->hits > 0 ? $project->hits : 1),2);

                // $project->ir =  number_format((($project->complete)*100)/($project->complete+$project->disqualify > 0 ? $project->complete+$project->disqualify : 1),2); 

                // //vikram

                $project->ir =  number_format((($project->complete - $project->disqualify)*100)/($project->hits > 0 ? $project->hits : 1),2);
                 // devesh
            }
        }

        $data['success'] = true;
        $data['projects'] = $projects;
        $data['total'] = $total;
        return Response::json($data,200,[]);

    }

    public function getProjectFilterData(){

        $clients = DB::table('clients')->select('id','clientName','contactPerson')->get();
        $data['statusOptions'] = Project::getStatusOptions();
        $data['countries'] = DB::table('countries')->select('id','name')->get();
        $data['clients'] = DB::table('clients')->select('id','clientName','contactPerson')->get(); 


        $data['projects'] = DB::table('projects')->select('id','project_name')->get();
        $data['projectManagers'] = DB::table('users')
        ->select('users.user_name','users.id')
        ->leftjoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','Project Manager')
        ->get();

        $data['salesManagers'] = DB::table('users')
        ->select('users.user_name','users.id')
        ->leftjoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','Sales Manager')
        ->get();

        $data['success'] = true;
        $data['clients'] = $clients;
        return Response::json($data,200,[]);

    }

    public function add($id = 0){

        $check = DB::table('projects')->where('id',$id)->first();

       $project = DB::table('projects')->select('projects.id','projects.project_name','countries.name as country_name')->leftjoin('countries','countries.id','=','projects.country_id')->where('projects.id',$id)->first();


        if($check){
            if($check->surveyId){

                $project = DB::table('projects')->select('projects.id','projects.project_name','countries.name as country_name')->leftjoin('countries','countries.countryID','=','projects.country_id')->where('projects.id',$id)->first();

            }
        }

        return view('admin.projects.add',["project_id" => $id, 'project' => $project]);
    }

    public function addInit($project_id = 0){
        $project_data = Project::find($project_id);

        $stastics = new stdClass();


        $all_devices_ids = [];
        $all_checklist_ids = [];

        if($project_data){
            $all_devices_ids = explode(",", $project_data->device);
            $all_checklist_ids = explode(",", $project_data->security_check_list);

            if($project_data->start_date){
                $project_data->start_date = date('m/d/Y',strtotime($project_data->start_date));
            }
            if($project_data->end_date){
                $project_data->end_date = date('m/d/Y',strtotime($project_data->end_date));
            }

            $surveyInfo = DB::table('start_survey_informations')->where('pid',$project_id)->get();

            $hits = 0;
            $redirect = 0;
            $complete = 0;
            $disqualify = 0;
            $quotaFull = 0;
            $securityTerm = 0;
            $interval = 0;

            foreach ($surveyInfo as $info) {
                $hits = $hits+1;

                if($info->status == 0){
                    $redirect = $redirect+1;
                }

                if($info->status == 1){
                    $complete = $complete+1;
                }

                if($info->status == 2){
                    $disqualify = $disqualify+1;
                }

                if($info->status == 3){
                    $quotaFull = $quotaFull+1;
                }

                if($info->status == 4){
                    $securityTerm = $securityTerm+1;
                }

                $interval += strtotime($info->end_time)-(strtotime($info->start_time));
            }

            $stastics->complete = $complete;
            $stastics->disqualify = $disqualify;
            $stastics->quotaFull = $quotaFull;
            $stastics->securityTerm = $securityTerm;
            $stastics->hits = $hits;
            $stastics->redirect = $redirect;
            $stastics->epc = $project_data->cpc * $redirect;
            $stastics->abendond =  number_format((($hits - $redirect)*100)/($hits > 0 ? $hits : 1),2);
            $stastics->completeSurvey = $hits - $redirect;
            $stastics->ir =  number_format((($stastics->completeSurvey - $disqualify)*100)/($hits > 0 ? $hits : 1),2);
            $stastics->loi = 15;

        }

        $settings = DB::table('api_settings')->first();
        $client_id = $settings ? $settings->client_id : 0;


        if($client_id){
        $countries = DB::table('countries')->select('countryID as id','name')->where('client_id',$client_id);
        } else {
        $countries = DB::table('countries')->select('id','name')->where('client_id',$client_id);
        }

        $countries = $countries->get();

        if(sizeof($countries) == 0){
            $countries = DB::table('countries')->select('id','name')->get();
        }

        $securityChecklist = Project::getSecurityChecklist();
        $studyTypes = Project::getStudyTypes();
        $statusOptions = Project::getStatusOptions();
        $devices = Project::getDevices();
        $languages = DB::table('languages')->select('id','language_name')->get();
        $clients = DB::table('clients')->select('id','clientName','contactPerson')->get(); 
        $currency = DB::table('currencies')->select('id','currency_name')->get();
        $vendor = DB::table('vendors')->select('id','vendorName')->get();
        $projects = DB::table('projects')->select('id','project_name')->get();


        $projects->prepend((object)['id' => -1, 'project_name' => 'Self Project']);


        $projectManagers = DB::table('users')
        ->select('users.user_name','users.id')
        ->leftjoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','Project Manager')
        ->get();

        $salesManagers = DB::table('users')
        ->select('users.user_name','users.id')
        ->leftjoin('roles','roles.id','=','users.role_id')
        ->where('roles.name','Sales Manager')
        ->get();

        $data['success'] = true;

        $data['project_data'] = $project_data; 
        $data['securityChecklist'] = $securityChecklist; 
        $data['all_devices_ids'] = $all_devices_ids; 
        $data['all_checklist_ids'] = $all_checklist_ids; 
        $data['studyTypes'] = $studyTypes; 
        $data['statusOptions'] = $statusOptions; 
        $data['devices'] = $devices; 
        $data['languages'] = $languages; 
        $data['countries'] = $countries; 
        $data['clients'] = $clients; 
        $data['currency'] = $currency; 
        $data['vendor'] = $vendor; 
        $data['projects'] = $projects; 
        $data['projectManagers'] = $projectManagers; 
        $data['salesManagers'] = $salesManagers; 
        $data['stastics'] = $stastics; 

        return Response::json($data,200,[]);
    }


    public function saveProject(Request $request)
    {
        $validator = Validator::make(
            [
                "project_name" => $request->project_name,
                "parent_project_id" => $request->parent_project_id,
                "study_type" => $request->study_type,
                "country_id" => $request->country_id,
                "language_id" => $request->language_id,
                "currency_id" => $request->currency_id,
                "cpc" => $request->cpc,
                "survey_link" => $request->survey_link,
                "req_complete" => $request->req_complete,
                // "qouta_buffer_complete" => $request->qouta_buffer_complete,
                "loi" => $request->loi,
                'device' => $request->all_devices_ids,
                "client_id" => $request->client_id,
                "project_manager_id" => $request->project_manager_id,
                "sales_manager_id" => $request->sales_manager_id,
                // "start_date" => $request->start_date,
                // "end_date" => $request->end_date,
            ],
            [
                "project_name" => "unique:projects,project_name,". $request->id,
                "parent_project_id" => "required",
                "study_type" => "required",
                "country_id" => "required",
                "language_id" => "required",
                "currency_id" => "required",
                "cpc" => "required",
                "survey_link" => "required",
                "req_complete" => "required",
                // "qouta_buffer_complete" => "required",
                "loi" => "required",
                'device' => "required",
                "client_id" => "required",
                "project_manager_id" => "required",
                "sales_manager_id" => "required",
                // "start_date" => "required|date|after_or_equal:today". $request->id,
                // "end_date" => "required|date|after_or_equal:today". $request->id,
            ]
        );

        if ($validator->passes()) {

            if($request->id == 0){
                $project = new Project();
                if($request->all_devices_ids){
                    $project->device = implode(",", $request->all_devices_ids);
                }
                $message = "Data was successfuly store";
            } else {
                $project = Project::find($request->id);
               
                if ($project && $request->all_devices_ids) {
                    $project->device = $request->all_devices_ids;
                    if ($project->device) {
                        $project->device = implode(",", $project->device);
                    }
                }
                if ($request->all_checklist_ids) {
                    $project->security_check_list = $request->all_checklist_ids;
                    if ($project->security_check_list) {
                        $project->security_check_list = implode(",",$project->security_check_list);
                    }
                }

                $message = "Data was successfuly Updated";
            }

            $project->project_name = $request->project_name;
            $project->parent_project_id = $request->parent_project_id;
            $project->study_type = $request->study_type;
            $project->country_id = $request->country_id;
            $project->language_id = $request->language_id;
            $project->currency_id = $request->currency_id;
            $project->cpc = $request->cpc;
            $project->survey_link = $request->survey_link;
            $project->survey_test_link = $request->survey_test_link;
            $project->req_complete = $request->req_complete;
            // $project->qouta_buffer_complete = $request->qouta_buffer_complete;
            $project->loi = $request->loi;
            $project->ir = $request->ir;
            $project->client_id = $request->client_id;
            $project->project_manager_id = $request->project_manager_id;
            $project->sales_manager_id = $request->sales_manager_id;
            $project->start_date = date("Y-m-d");
            $project->notes = $request->notes;
            $project->project_brief = $request->project_brief;
            $project->status = $request->status;
            $project->complete_total_after_redirect = $request->complete_total_after_redirect;
            $project->save();

            $data['success'] = true;
            $data["message"] =$message;
           
        } else {
            $data["success"] = false;
            $data["message"] = $validator->errors()->first();
        
        }
        return Response::json($data,200,[]);

    }

    public function deleteProject($project_id){
        User::pageAccess(5);
        DB::table('projects')->where('id',$project_id)->delete();
        $data['success'] = true;
        $data["message"] ="Project is successfuly deleted";
        return Response::json($data,200,[]);
    }

    public function getProjectDetail(Request $request){
        $projectDetailData = DB::table('projects')->select("project_name","parent_project_id","study_type","country_id","language_id","currency_id","cpc","survey_link","survey_test_link","req_complete","qouta_buffer_complete","loi","device","client_id","project_manager_id","sales_manager_id","start_date","end_date","notes","project_brief","status","security_check_list")->where('id',$request->project_id)->first();


        $all_devices_ids = [];

        if($projectDetailData){
            $all_devices_ids = explode(",", $projectDetailData->device);
            $projectDetailData->parent_project_id = $request->project_id;

            if($projectDetailData->start_date){
                $projectDetailData->start_date = date('m/d/Y',strtotime($projectDetailData->start_date));
            }
            if($projectDetailData->end_date){
                $projectDetailData->end_date = date('m/d/Y',strtotime($projectDetailData->end_date));
            }
        }

        $data['success'] = true;
        $data["projectDetailData"] = $projectDetailData;
        $data["all_devices_ids"] = $all_devices_ids;
        return Response::json($data,200,[]);
    }

    public function viewProjectSurveyDetails($project_id, $status = null){
        return view('admin.projects.project_survey_info',["project_id" => $project_id, "status" => $status]);
    }

    public function showProjectSurveyDetails(Request $request){

        $page_no = $request->page_no;
        $max_per_page = $request->max_per_page;

        $countries = DB::table('countries')->pluck('name','id')->toArray();
        $client_countries = DB::table('countries')->pluck('name','countryID')->toArray();

        $surveyInformations = DB::table('start_survey_informations')->select('start_survey_informations.*','projects.project_name','projects.client_api_data','projects.country_id','vendors.vendorName','clients.clientName')
        ->leftjoin('projects','projects.id','=','start_survey_informations.pid')
        ->leftjoin('vendors','vendors.id','=','start_survey_informations.gid')
        ->leftjoin('clients','clients.id','=','projects.client_id');

        if($request->project_id){
            $surveyInformations = $surveyInformations->where('start_survey_informations.pid',$request->project_id);
        }

        if($request->status){
            $surveyInformations = $surveyInformations->where('start_survey_informations.status',$request->status);
        }

        if($request->gid){
            $surveyInformations = $surveyInformations->where('gid',$request->gid);
        }

        if($request->status){
            $surveyInformations = $surveyInformations->where('start_survey_informations.status',$request->status);
        }

        if($request->country_id){
            $surveyInformations = $surveyInformations->where('projects.country_id',$request->country_id);
        }

        $total = $surveyInformations->count();

        if($request->export == 1){
            $surveyInformations = $surveyInformations->orderBy('start_survey_informations.id','DESC')->get();

        } else {
            $surveyInformations = $surveyInformations->skip(($page_no-1)*$max_per_page)->take($max_per_page)->orderBy('start_survey_informations.id','DESC')->get();
        }

        $StatusOptions = Project::StatusOptions();

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

            $h = floor($interval / 3600); // 3600 seconds in an hour
            $m = floor(($interval % 3600) / 60); // 60 seconds in a minute
            $s = $interval % 60;
            $surveyInformation->loi = sprintf("%02d:%02d:%02d", $h, $m, $s);

        }

        if($request->export == 1){
            include(app_path()."/ExcelExport/survey_detail.php");
            $data["excel_link"] = url('uploads/'.$filename);
        }

        $data['success'] = true;
        $data['total'] = $total;
        $data["surveyInformations"] = $surveyInformations;
        return Response::json($data,200,[]);

    }

    public function saveStatus(Request $request){
        User::pageAccess(5);
        DB::table('projects')->where('id',$request->project_id)->update(["status" => $request->status_id]);

        $statusData = Project::showStatusOptions();
        $status = $statusData[$request->status_id];

        $data['success'] = true;
        $data['message'] = "Status was successfuly changed";
        $data["status"] = $status;
        return Response::json($data,200,[]);

    }

    public function getProjectSurveyFilterData(){

        $data['surveyStatusOptions'] = Project::getSurveyStatusOptions();
        $data['countries'] = DB::table('countries')->select('id','name')->get();
        $data['success'] = true;
        return Response::json($data,200,[]);

    }

    public function approved($id){
        $project = DB::table('projects')->where('id',$id)->first();

        if($project->approved == 0){
            $approve = 1;
        } else {
            $approve = 0;
        }
        DB::table('projects')->where('id',$id)->update(["approved" => $approve]);

        $data['success'] = true;
        $data['approve'] = $approve;
        return Response::json($data,200,[]);

        // return Redirect::back()->with("message","Status is successfully changed");
    }

    public function download($project_id){
        $surveyInformations = DB::table('start_survey_informations')
        ->select('start_survey_informations.*','projects.project_name','vendors.vendorName','clients.clientName')
        ->leftJoin('projects', 'projects.id', '=', 'start_survey_informations.pid')
        ->leftJoin('vendors', 'vendors.id', '=', 'start_survey_informations.gid')
        ->leftJoin('clients', 'clients.id', '=', 'projects.client_id')
        ->where('pid', $project_id)
        ->orWhere(function ($query) {
            $query->whereNotNull('start_survey_informations.email')
            ->orWhereNotNull('start_survey_informations.zip')
            ->orWhereNotNull('start_survey_informations.age')
            ->orWhereNotNull('start_survey_informations.gender');
        })->get();

        include(app_path()."/ExcelExport/ask_to_redirect.php");
    }    



     public function getSelfParent(Request $request){

        $term = $request->term;
        $term = str_replace(" ","%",$term);
        $term = $request->term;
        $term = str_replace(" ", "%", $term);

        $projects = DB::table('projects')
            ->select('id as value', 'project_name as label')
            ->where('project_name', 'LIKE', '%' . $term . '%')
            ->take(20)
            ->get();




        return $projects;
    }

}
