<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Vendor;
use App\Models\Project;
use App\Models\MangeSupplier;
use App\Models\User;
use App\Models\StartSurveyInformation;
use Stevebauman\Location\Facades\Location;
use Redirect, Validator, Session, DB, Input, Hash, Response, Agent;
use Illuminate\Support\Facades\Http;

class LinkController extends Controller
{
    
    public function surveyStart(Request $request){

        preg_match_all('!\d+\.*\d*!', $request->pid, $matchPid);
        preg_match_all('!\d+\.*\d*!', $request->gid, $matchGid);

        $project = DB::table('projects')->select('projects.*')->where('id',$matchPid[0])->first();

        $country = DB::table('countries')->where('id',$project->country_id)->first();

        $ip = $request->ip();
        // $ip = "106.211.29.195";

        $location = Location::get($ip);

        if($project->security_check_list){
            $security_check_list = explode(",", $project->security_check_list);

            if(in_array(1,$security_check_list)){
                if($location->countryName != $country->name){
                    $message = "Country mismatch";
                    return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $request->pid, "uid" => ""]);
                }
            }
        }


        if(Agent::isDesktop()) {
            $device = 1;
        } elseif (Agent::isTablet()) {
            $device = 3;
        } elseif (Agent::isMobile()) {
            $device = 2;
        }

        if($project->device){
            $devices = explode(",", $project->device);
            if($device == 1){
                if(!in_array($device,$devices)){
                    $message = "Moniter device mismatch";
                    return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $request->pid, "uid" => ""]);
                }
            }
            
            if($device == 2){
                if(!in_array($device,$devices)){
                    $message = "Smart Phone device mismatch";
                    return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $request->pid, "uid" => ""]);
                }
            }

            if($device == 3){
                if(!in_array($device,$devices)){
                    $message = "Tablet device mismatch";
                    return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $request->pid, "uid" => ""]);
                }
            }
        }

        $manage_supplier = DB::table('manage_suppliers')->select('data_redirect')->where('project_id', $matchPid[0])->where('id',$matchGid[0])->first();
        // dd($matchGid[0]);

        $openQuestion = [];

        if($manage_supplier){
            $openQuestion = explode(",",$manage_supplier->data_redirect);
        }

        $qualifications = DB::table('apply_qualifications')->where("project_id",$matchPid)->get();

        foreach ($qualifications as $qualification) {
            $qualification->question = DB::table('questions')->where('id',$qualification->question_id)->first();

            $qualification->question->options = DB::table('options')->where('question_id',$qualification->question->id)->get();
        }

        $alreadyExist = DB::table('start_survey_informations')
            ->where('pid', $request->pid)
            ->where('gid', $request->gid)
            ->where('user_id', $request->user_id)
            ->first();

        if ($alreadyExist) {
            return view('front-end.message', [
                'message' => 'User id Already exist...',
                "ip" => $request->ip(),
                "pid" => $request->pid,
                "uid" => $request->user_id
            ]);
        }

        return $this->storeStartSurveyInformation($request);

        return view('admin.links.start_survay',["pid" => $request->pid, "gid" => $request->gid, "openQuestion" => $openQuestion, "qualifications" => $qualifications]);

    }

    public function storeStartSurveyInformation(Request $request){


        $questionIds = $request->select_question;
        
        if($questionIds){

            $questions = DB::table('questions')->whereIn('id',$questionIds)->get();
        
            foreach ($questions as $question) {
                if($question->type == 1){
                    $inputValue = $request->input('select_single_option_' . $question->id);
    
                    $option = DB::table('options')->select('answer')->where('question_id',$question->id)->where('answer',1)->first();
    
                    if($option->answer != $inputValue){
                        $message = $question->question_name." answer is mismatch";
                        return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $request->pid, "uid" => $request->user_id]);
                    }
                } if($question->type == 2){
    
                    $inputValue = $request->input('select_multiple_option_' . $question->id);
    
                    if(!$inputValue){
                        $inputValue = [];
                    }
    
                    $options = DB::table('options')->where('question_id',$question->id)->where('answer',1)->pluck('id')->toArray();
    
                    $diff1 = array_diff($options, $inputValue);
                    $diff2 = array_diff($inputValue, $options);
    
                    if (empty($diff1) && empty($diff2)) {
    
                    } else {
                        $message = $question->question_name." answer is mismatch";
                        return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $request->pid, "uid" => $request->user_id]);
                    }
                }
            }
        }

        $servay_info = new StartSurveyInformation();

        preg_match_all('!\d+\.*\d*!', $request->pid, $matchPid);

        $project = DB::table('projects')->select('projects.*')->where('id',$matchPid[0])->first();


        if($project->status == 1){
            return Redirect::back()->with("message","This project in bidding stage");
        }
        if($project->status == 4){
            return Redirect::back()->with("message","This project in hold stage");
        }
        if($project->status == 5){
            return Redirect::back()->with("message","This project in complete stage");
        }
        if($project->status == 6){
            return Redirect::back()->with("message","This project in awaiting stage");
        }
        if($project->status == 7){
            return Redirect::back()->with("message","This project in closed stage");
        }

        if(!$request->user_id){
            return Redirect::back()->with("message","Please Change user id by link");
        }

        $check = DB::table('start_survey_informations')->where('pid',$request->pid)->where('gid',$request->gid)->where('user_id',$request->user_id)->first();

        if($check){
            return Redirect::back()->with("message","User id Already exist...");
        }

        $checkComplete = DB::table('start_survey_informations')->where('pid',$request->pid)->where('status',1)->where('gid',$request->gid)->count();

        $checkQuotaBuffer = DB::table('start_survey_informations')->where('pid',$request->pid)->where('gid',$request->gid)->count();

        if($checkComplete == $project->req_complete){
            return Redirect::back()->with("message","Survey  Complete Please contact system Administrator");
        }

        // if($checkQuotaBuffer == $project->qouta_buffer_complete){
        //     return Redirect::back()->with("message","Survey Quota Buffer Full Please contact system Administrator");
        // }

        $userAgent = $request->header('User-Agent');

        if (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident/') !== false) {
            $browser = 'Internet Explorer';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            $browser = 'Microsoft Edge (Legacy)';
        } elseif (strpos($userAgent, 'Edg') !== false) {
            $browser = 'Microsoft Edge (Chromium-based)';
        } elseif (strpos($userAgent, 'Chrome') !== false) {
            $browser = 'Google Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $browser = 'Mozilla Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $browser = 'using Safari';
        } else {
            $browser = 'unrecognized browser';
        }

        $desiredLength = 15;
        $encryptionKey = 'YourEncryptionKey';

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = openssl_encrypt($request->user_id, 'aes-256-cbc', $encryptionKey, 0, $iv);
        $paddingLength = $desiredLength - strlen($encryptedData);

        if ($paddingLength < 0) {
            $ref_id =  substr($encryptedData, 0, $desiredLength);
        } else {
            $padding = openssl_random_pseudo_bytes($paddingLength);
            $ref_id = $encryptedData . $padding;
        }
        
        
        
        $symbolsToRemove = ["!", "@", "#", "$", "%", "&", "|", "+", "/"];

        $replacementLetter = "x";

        $ref_id = str_replace($symbolsToRemove, $replacementLetter, $ref_id);
        
        

        $servay_info->pid = $request->pid; 
        $servay_info->gid = $request->gid; 
        $servay_info->start_ip_address = $request->ip();   
        $servay_info->end_ip_address = null;    
        $servay_info->status = 0;     
        $servay_info->email = $request->email;  
        $servay_info->zip = $request->zip; 
        $servay_info->age = $request->age; 
        $servay_info->gender = $request->gender;
        $servay_info->user_id = $request->user_id;
        $servay_info->ref_id = $ref_id;
        $servay_info->start_time = date("Y-m-d H:i:s");
        $servay_info->browser = $browser;    
        $servay_info->date = date("Y-m-d");    
        $servay_info->save();  

        if($project->status == 2){

            $query = parse_url($project->survey_test_link, PHP_URL_QUERY);

            if ($query) {
                $project->survey_test_link .= $ref_id;
            } else {
                $project->survey_test_link .= '?user_id='.$ref_id;
            }

            $surveyLink = $project->survey_test_link;
        }

        if($project->status == 3){

            $query = parse_url($project->survey_link, PHP_URL_QUERY);

            if ($query) {
                $project->survey_link .= $ref_id;
            } else {
                $project->survey_link .= '?user_id='.$ref_id;
            }

            $surveyLink = $project->survey_link;
        }

        if($project->surveyId){


            $ip = $request->ip(); 
            // $ip = "223.184.189.125"; 
            $txn = $ref_id;

            // $rawLink = $project->survey_link;

            // $link = str_replace(['{{ip}}', '{{txn}}'],[$ip, $txn],$rawLink);

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'ZAMP-KEY' => 'b9ZJiXDgbvrRwEoJJaFcWDVqAKmMStDF',
            ])->get('https://surveysupply.zamplia.com/api/v1/Surveys/GenerateLink', [
                'SurveyId' => $project->surveyId,
                'IpAddress' => $ip,
                'TransactionId' => $txn,
            ]);

            $data = $response->json();

            $surveyLink = null;

            if (isset($data['success']) && $data['success'] === true && isset($data['result']['data'][0]['LiveLink'])) {
                $surveyLink = $data['result']['data'][0]['LiveLink'];
            }


            // $parsedUrl = parse_url($project->survey_link);

            // $queryString = $parsedUrl['query'];

            // parse_str($queryString, $queryParams);

            // $survnum = $queryParams['survnum'] ?? null;
            // $supcode = $queryParams['supcode'] ?? null;
            // $pid = $request->user_id;
            // $secretkey = 'gAaKU5PCVdMmqcQ6u8Wunh4AMHA5fanUN2MqCRwUsTkavRMR';

            // $token = md5(base64_decode($survnum) . (string)$supcode . (string)$pid . $secretkey);

            // $queryParams['pid'] = $pid;
            // $queryParams['token'] = $token;

            // $newQueryString = http_build_query($queryParams);

            // $surveyLink = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'] . '?' . $newQueryString;
        }

        return Redirect::to($surveyLink);
    }

    public function surveyInitialize(Request $request){

        $vendorRedirect = '';
        // $project = DB::table('start_survey_informations')->where('ref_id',$request->uid)->first();

        // $project = DB::table('start_survey_informations')->where('user_id',$request->uid)->where('start_ip_address',$request->ip())->orderBy("id","DESC")->first();

        
        $project = DB::table('start_survey_informations')->where('ref_id',$request->uid)->orderBy("id","DESC")->first();
        
        if($project){
            $projectData = DB::table('projects')->where('id',$project->pid)->first();
        } else {
            $projectData = null;
            $pid = null;
        }


        if(!$projectData || !$project){
            
            $message = "Project ". $request->status;
            return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $pid, "uid" => $request->uid]);
        }
        
        
        $servay_info = StartSurveyInformation::find($project->id);

        $flag = false;
        if($projectData->complete_total_after_redirect){
            $vendor_id = $servay_info->gid;

            $original_vendor = DB::table('manage_suppliers')->select('vendor_id')->where('id',$vendor_id)->first();

            $vendor = DB::table('vendors')->where('id',$original_vendor->vendor_id)->first();

            $count = DB::table('start_survey_informations')->where('pid',$projectData->id)->where('gid',$vendor_id)->count();


            if($count > $projectData->complete_total_after_redirect){
                $flag = true;
            }


        }
        
        
        
        if($request->status == 'complete'){
            $status = 1;
            $m = "Complete";
        }elseif($request->status == 'disqualify'){
            $status = 2;
            $m = "Disqualify";
        }elseif($request->status == 'quotaFull'){
            $status = 3;
            $m = "Quota Full";
        }elseif($request->status == 'securityTerm'){
            $status = 4;
            $m = "Security Term";
        }else {
            $status = 2;
            $m = "Disqualify";
        }
    
        $servay_info->status = $status;    
        $servay_info->end_time = date("Y-m-d H:i:s");
        $servay_info->end_ip_address = $request->ip();    
        $servay_info->save(); 

        if($flag){

            if($status == 1){
                return Redirect::to($vendor->after_total_complete_link);
            }

            if($status == 2){
                return Redirect::to($vendor->after_total_disqualify_link);
            }

            if($status == 3){
                return Redirect::to($vendor->after_total_qoutafull_link);
            }

            if($status == 4){
                return Redirect::to($vendor->after_total_security_term_link);
            }

        }
        
        
        if($project->vendor_id == 1){
            $message = $m;
            return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $project->pid, "uid" => $request->uid]);
        }


        if(!$project){
            $message = "Please enter correct survey details";
            return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $pid, "uid" => $request->uid]);
        }

        $vendor = DB::table('manage_suppliers')->where('project_id',$project->pid)->where('id',$project->gid)->first();

        $servay_info->vendor_id = $vendor->vendor_id;    
        $servay_info->save(); 

        $complete = null;
        $disqualify = null;
        $quota_full = null;
        $security = null;

        // $survetTimeDiff = floor(((strtotime($projectData->end_date) - strtotime($projectData->start_date)) % 3600)/60);

        // $servayTime = $projectData->loi;

        // $servay_max_time = $servayTime * 2.5;
        // $servay_min_time = $servayTime * 0.6;

        // if($survetTimeDiff >= $servay_min_time || $survetTimeDiff >= $servay_max_time){
            
        // } else {
        //     $request->status = 2;
        // }

        if($project->pid && $project->gid){
            if($request->status == 'complete'){
                $vendorRedirect = $vendor->completeLink;
            }elseif($request->status == 'disqualify'){
                $vendorRedirect = $vendor->disqualifyLink;
            }elseif($request->status == 'quotaFull'){
                $vendorRedirect = $vendor->qoutafullLink;
            }elseif($request->status == 'securityTerm'){
                $vendorRedirect = $vendor->securityTermlink;
            }else {
                $vendorRedirect = $vendor->disqualifyLink;
            }

        }



        if($projectData->security_check_list){
            $security_check_list = explode(",", $projectData->security_check_list);
            if(in_array(2,$security_check_list)){
                if($servay_info->start_ip_address != $servay_info->end_ip_address){
                    $status = 2;
                }
            }
        }
        
        if(!$vendorRedirect){
            $message = $request->status;
            return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $project->id, "uid" => $request->uid]);
        }

        

        if($project->pid && $project->gid){

            $query = parse_url($vendorRedirect, PHP_URL_QUERY);

            if ($query) {
                $vendorRedirect .= $project->user_id;
            } else {
                $vendorRedirect .= '?Uid='.$project->user_id;
            }

            return Redirect::to($vendorRedirect);
        }

        if($status == 2){
            $message = "Terminate";
            return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $project->user_id, "uid" => $request->user_id]);
        }

        if($project->pid && $project->gid == null){
            $message = "Admin Link";
            return view('front-end.message',['message' => $message,"ip" => $request->ip(),"pid" => $project->user_id, "uid" => $request->user_id]);
        }
    }

}

