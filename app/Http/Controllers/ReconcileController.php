<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Countries, App\Models\Currency, App\Models\Language, App\Models\Client, App\Models\Vendor, App\Models\Project;
use Redirect, Validator, Session, DB, stdClass, Input, Hash, Response;

class ReconcileController extends Controller
{
    
    public function index(Request $request, $project_id){

        if(!$request->ref_id){
            $surveyInformations = [];
        } else {
            $refIds = explode("\r\n", $request->ref_id);

            $surveyInformations = DB::table('start_survey_informations')->select('start_survey_informations.*','projects.project_name','vendors.vendorName','clients.clientName')
                ->leftjoin('projects','projects.id','=','start_survey_informations.pid')
                ->leftjoin('vendors','vendors.id','=','start_survey_informations.gid')
                ->leftjoin('clients','clients.id','=','projects.client_id')
                ->whereIn('ref_id',$refIds)->get();

            $StatusOptions = Project::StatusOptions();

            foreach ($surveyInformations as $surveyInformation) {
                $surveyInformation->start_date = date("m-d-Y",strtotime($surveyInformation->start_time));
                $surveyInformation->end_date = date("m-d-Y",strtotime($surveyInformation->end_time));
                $surveyInformation->start_time = date("H:i:s",strtotime($surveyInformation->start_time));
                $surveyInformation->end_time = date("H:i:s",strtotime($surveyInformation->end_time));

                $surveyInformation->status = $StatusOptions[$surveyInformation->status];
            }
        }

        return view('admin.reconcile.index',["project_id" => $project_id, "surveyInformations" => $surveyInformations]);
    }

}
