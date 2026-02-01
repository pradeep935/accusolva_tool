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


class SupplierController extends Controller
{
    public function index($project_id){
        return view('admin.suppliers.index',["project_id" => $project_id]);
    }

    public function init(Request $request){

        $showStatusOptions = Project::showStatusOptions();

        $check = DB::table('manage_suppliers')->where('project_id',$request->project_id)->where('internal_splier',1)->first();

        $checkVendor = DB::table('vendors')->where('internal_panel',1)->first();

        if(!$check){
            DB::table('manage_suppliers')->insert([
                "project_id" => $request->project_id,
                "internal_splier" => 1,
                "vendor_id" => $checkVendor ? $checkVendor->id : 1,
            ]);
        }
        $projectGIDs = [];
        
        $suppliers = DB::table('manage_suppliers')->select("manage_suppliers.*",'vendors.vendorName','vendors.contactPerson','vendors.completeLink as vendorCompleteLink','vendors.disqualifyLink as vendorDisqualifyLink','vendors.qoutafullLink as vendorQoutafullLink','vendors.securityTermlink as vendorSecurityTermlink','projects.id as projectId','projects.project_name')
        ->leftJoin('vendors','vendors.id','manage_suppliers.vendor_id')
        ->leftJoin('projects','projects.id','manage_suppliers.project_id')
        ->where('manage_suppliers.project_id',$request->project_id)->get();


        $data_redirect_ids = [];


        foreach ($suppliers as $supplier) {

            if($supplier->completeLink){
                $supplier->completeLink = $supplier->completeLink;
            } else {
                $supplier->completeLink = $supplier->vendorCompleteLink;
            }

            if($supplier->disqualifyLink){
                $supplier->disqualifyLink = $supplier->disqualifyLink;
            } else {
                $supplier->disqualifyLink = $supplier->vendorDisqualifyLink;
            }

            if($supplier->qoutafullLink){
                $supplier->qoutafullLink = $supplier->qoutafullLink;
            } else {
                $supplier->qoutafullLink = $supplier->vendorQoutafullLink;
            }

            if($supplier->securityTermlink){
                $supplier->securityTermlink = $supplier->securityTermlink;
            } else {
                $supplier->securityTermlink = $supplier->vendorSecurityTermlink;
            }

            if($supplier->data_redirect){
                $supplier->data_redirect_ids = explode(",", $supplier->data_redirect);
            } else {
                $supplier->data_redirect_ids = [];
            }

            $supplier->newUrl = url('/').'/survey-start'.'?'.'pid='.$supplier->project_id.'&'.'gid='.$supplier->id.'&user_id=';

            $supplier->newTestUrl = url('/').'/survey-start-test'.'?'.'pid='.$supplier->project_id.'&'.'gid='.$supplier->id.'&user_id=';

            $projectGIDs[] = $supplier->id;

            if($supplier->status){
                $supplier->showStatus = $showStatusOptions[$supplier->status];
            } else {
                $supplier->showStatus = null;
            }

        }


        $surveyInformations = DB::table('start_survey_informations')->whereIn('gid',$projectGIDs)->get();

        foreach($suppliers as $supplier){
            $supplier->hits = 0;
            $supplier->complete = 0;
            $supplier->disqualify = 0;
            $supplier->quota_full = 0;
            $supplier->securityTerm = 0;
            $supplier->drop = 0;

            foreach ($surveyInformations as $surveyInformation) {
                if($supplier->id == $surveyInformation->gid){
                    $supplier->hits++;
                    if($surveyInformation->status == 1) $supplier->complete++;
                    if($surveyInformation->status == 2) $supplier->disqualify++;
                    if($surveyInformation->status == 3) $supplier->quota_full++;
                    if($surveyInformation->status == 4) $supplier->securityTerm++; 
                    if($surveyInformation->status == 0) $supplier->drop++; 
                }
                $supplier->abendond =  number_format((($supplier->hits - $supplier->drop)*100)/($supplier->hits > 0 ? $supplier->hits : 1),2);

                $supplier->ir =  number_format((($supplier->complete - $supplier->disqualify)*100)/($supplier->hits > 0 ? $supplier->hits : 1),2);
            }
        }
        $data['success'] = true;
        $data['project'] = DB::table('projects')->select('cpc')->where('id',$request->project_id)->first();
        $data['suppliers'] = $suppliers;
        $data['data_redirect_ids'] = $data_redirect_ids;
        return Response::json($data,200,[]);
    }


    public function add($project_id){
        $vendors = DB::table("vendors")->select('id','vendorName')->get();
        return view('admin.suppliers.add',["project_id" => $project_id, "vendors" => $vendors]);
    }

    public function getVendorDetails(Request $request){
        $vendor = DB::table("vendors")->where('id',$request->vendor_id)->first();

        $data['success'] = true;
        $data['vendor'] = $vendor;
        return Response::json($data,200,[]);
    }

    public function saveSuplierData(Request $request){

        if($request->id == 0){
            $mangeSupplier = new MangeSupplier();
        } else {
            $mangeSupplier =  MangeSupplier::find($request->id);
        }

        if($request->data_redirect_ids){
            $dataRedirect = implode(',', $request->data_redirect_ids);
        } else {
            $dataRedirect = null;
        }

        $mangeSupplier->project_id = $request->project_id;
        $mangeSupplier->vendor_id = $request->vendor_id;
        $mangeSupplier->cost_per_complete = $request->cost_per_complete;
        $mangeSupplier->complete_request = $request->complete_request;
        $mangeSupplier->max_redirect = $request->max_redirect;
        $mangeSupplier->data_redirect = $dataRedirect;
        $mangeSupplier->notes = $request->notes;
        $mangeSupplier->completeLink = $request->completeLink;
        $mangeSupplier->disqualifyLink = $request->disqualifyLink;
        $mangeSupplier->securityTermlink = $request->securityTermlink;
        $mangeSupplier->qoutafullLink = $request->qoutafullLink;
        $mangeSupplier->status = $request->status;
        $mangeSupplier->save();

        $data['success'] = true;
        $data['message'] = "Data was successfuly store";
        return Response::json($data,200,[]);

    }

    public function removeSuplier($removeSuplier_id){
        $supplier = DB::table('manage_suppliers')->where('id',$removeSuplier_id)->delete();
        $data['success'] = true;
        $data['message'] = "Data was successfuly Deleted";
        return Response::json($data,200,[]);


    }

    public function edit($id,$project_id){
        $supplier = DB::table('manage_suppliers')->where('id',$id)->first();
        $vendors = DB::table("vendors")->get();
        $project = DB::table('projects')->where('id',$supplier->project_id)->first();
        $vendorData = DB::table("vendors")->where('id',$supplier->vendor_id)->first();

        $dataRedirect = [];

        if($supplier->data_redirect){

            $dataRedirect = explode(",",$supplier->data_redirect);

        }

        $supplier_survey_record = DB::table('supplier_survey_records')->where('vendor_id',$id)->where('pid','PI'.$project->id.'D')->first();


        if(!$supplier_survey_record){

            $gid = MangeSupplier::GID($vendorData->id);
            $pid = MangeSupplier::PID($project->id);


            $newUrl = url('/').'/survey-initialize'.'?'.'pid='.$pid.'&'.'gid='.$gid.'&user_id=';

            $newTestUrl = url('/').'/survey-initialize-test'.'?'.'pid='.$pid.'&'.'gid='.$gid.'&user_id=';


            DB::table('supplier_survey_records')->insert([
                "vendor_id" => $supplier->vendor_id,
                "pid" => $pid,
                "gid" => $gid,
                "newUrl" => $newUrl,
                "newTestUrl" => $newTestUrl,
            ]);

        } else {

            $newUrl = $supplier_survey_record->newUrl;
            $newTestUrl = $supplier_survey_record->newTestUrl;

        }
        
        return view('admin.suppliers.edit',["supplier" => $supplier, "vendors" => $vendors,"panelList" => $newUrl, "vendorData" => $vendorData, "dataRedirect" => $dataRedirect, "newTestUrl" => $newTestUrl,"project_id" => $project_id]);

    }

    public function addEditInit(){
        $vendors = DB::table("vendors")->select('id','vendorName')->get();
        $statusOptions = Project::getStatusOptions();
        $dataToAskOnRedirect = Project::dataToAskOnRedirect();

        $data['success'] = true;
        $data['vendors'] = $vendors;
        $data['statusOptions'] = $statusOptions;
        $data['dataToAskOnRedirect'] = $dataToAskOnRedirect;
        return Response::json($data,200,[]);

    }

    public function showProjectSurveyDetails(Request $request){

        $suplierSurveyDetails = DB::table('start_survey_informations')->select('start_survey_informations.*','projects.project_name','vendors.vendorName','clients.clientName','countries.name as country_name')
        ->leftjoin('projects','projects.id','=','start_survey_informations.pid')
        ->leftjoin('vendors','vendors.id','=','start_survey_informations.vendor_id')
        ->leftjoin('clients','clients.id','=','projects.client_id')
        ->leftjoin('countries','countries.id','=','projects.country_id')
        ->where('pid',$request->pid)
        ->where('gid',$request->gid);

        if($request->status){
            $suplierSurveyDetails = $suplierSurveyDetails->where('start_survey_informations.status',$request->status);
        }

        $suplierSurveyDetails = $suplierSurveyDetails->get();

        $StatusOptions = Project::StatusOptions();

        foreach ($suplierSurveyDetails as $surveyInformation) {
            $surveyInformation->start_date = User::convertDateShow($surveyInformation->start_time);
            $surveyInformation->end_date = User::convertDateShow($surveyInformation->end_time);
            $surveyInformation->start_time = $surveyInformation->start_time ? date("H:i:s",strtotime($surveyInformation->start_time)) : null;
            $surveyInformation->end_time = $surveyInformation->end_time ? date("H:i:s",strtotime($surveyInformation->end_time)) : null;

            $surveyInformation->status = $StatusOptions[$surveyInformation->status];
        }

        $data['success'] = true;
        $data["suplierSurveyDetails"] = $suplierSurveyDetails;
        return Response::json($data,200,[]);

    }

    public function exportExcel(Request $request){
        $supplier_exports = $request->all();
        include(app_path()."/ExcelExport/surey_supplier_detail.php");

        $data['success'] = true;
        $data["excel_link"] = url('uploads/'.$filename);
        return Response::json($data,200,[]);

    }
}












