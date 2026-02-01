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


class QualificationController extends Controller
{
    public function index($project_id){
        return view('admin.qualification.index',["project_id" => $project_id]);
    }

    public function init(Request $request){

        $project_id = $request->project_id;

        $questions = DB::table('questions')->where('project_id',$project_id)->get();
        $project = DB::table('projects')->select('client_api_data')->where('id',$project_id)->first();
        foreach($questions as $question){
            $options =  DB::table("options")->where("question_id",$question->id)->get();
            $optionAnswers = DB::table("options")->where("question_id",$question->id)->where("answer",1)->get();

            $question->optionCheck = false;
            $question->optionAnswerCheck = false;

            if(sizeof($options) > 0) $question->optionCheck = true;
            if(sizeof($optionAnswers) > 0) $question->optionAnswerCheck = true;
        }

        $question_ids = DB::table('apply_qualifications')->where('project_id',$project_id)->pluck('question_id')->toArray();

        $check = DB::table('options')->where('project_id',$project_id)->first();

        if($check){
            $surveyId = false;
        } else {
            $surveyId = true;
        }

        $data['success'] = true;
        $data['question_ids'] = $question_ids;
        $data['questions'] = $questions;
        $data['surveyId'] = $surveyId;
        $data['project'] = $project;
        return Response::json($data,200,[]);

    }

    public function store(Request $request){


        $qualificationData = $request->qualificationData;
        $question_id = $qualificationData['question_id'];
        $options = $request->options;

        $checkQuestion = DB::table('questions')->where('id',$question_id)->first();

        if($checkQuestion){

            DB::table('questions')->where('id',$checkQuestion->id)->update([
                "question_name" => isset($qualificationData['question_name']) ? $qualificationData['question_name'] : null,
                "type" => isset($qualificationData['type']) ? $qualificationData['type'] : null,
            ]);

        } else {

            $question_id = DB::table('questions')->insertGetId([
                "question_name" => isset($qualificationData['question_name']) ? $qualificationData['question_name'] : null,
                "type" => isset($qualificationData['type']) ? $qualificationData['type'] : null,
            ]);

        }

        DB::table('options')->where('question_id',$question_id)->delete();

        foreach ($options as $option) {
            DB::table('options')->insert([
                "question_id" => $question_id,
                "option_name" => isset($option["option_name"]) ? $option["option_name"] : null,
                "answer" => isset($option["answer"]) ? $option["answer"] ? 1 : 0 : 0,
            ]);
        }

        $data['success'] = true;
        $data['message'] = "Data was successfuly store";
        return Response::json($data,200,[]);

    }

    public function delete($id){
        $supplier = DB::table('questions')->where('id',$id)->delete();
        $data['success'] = true;
        $data['message'] = "Data was successfuly Deleted";
        return Response::json($data,200,[]);


    }

    public function edit(Request $request){
        $data['qualificationData'] = DB::table('questions')->where('id',$request->question_id)->first();
        $options = DB::table('options')->where('question_id',$request->question_id)->get();

        foreach ($options as $option) {
            if($option->answer == 0){
                $option->answer = false;
            } else {
                $option->answer = true;
            }

        }
        $data['options'] = $options;

        $data['success'] = true;
        return Response::json($data,200,[]);

    }

    public function applyQualification(Request $request){

        $project_id = $request->project_id;
        $question_ids = $request->question_ids;

        DB::table('apply_qualifications')->where("project_id",$project_id)->delete();

        foreach ($question_ids as $question_id) {
            DB::table('apply_qualifications')->insert([
                "question_id" => $question_id,
                "project_id" => $project_id,
            ]);
        }

        $data['success'] = true;
        $data['message'] = "Data was successfuly apply";
        return Response::json($data,200,[]);

    }

    public function fetchApiQuestion(Request $request){

        $project_id = $request->project_id;
        $project = DB::table('projects')->where('id',$project_id)->first();
        $settings = DB::table('api_settings')->first();
        $client_id = $settings->client_id;
        $name = $settings->api_name;

        $clientData = Project::curl_fnt_country_wise_question_data($name,$project->country_id);
        $questionData = json_decode($clientData, true);
        if($questionData){
        DB::table('questions')->where('client_id',$client_id)->where('project_id',$project->id)->where('countryId',$project->country_id)->delete();

          foreach($questionData['data'] as $question){

            if($question['questionType'] == "Open End") $type = 3;
            if($question['questionType'] == "Single Select") $type = 1;
            if($question['questionType'] == "Multiple Select") $type = 2;
            if($question['questionType'] == "dummy") $type = 4;
            
            $id = DB::table('questions')->insertGetId([
                "question_name" => $question['questionText'],
                "questionKey" => $question['questionKey'],
                "questionType" => $question['questionType'],
                "client_id" => $client_id,
                "questionId" => $question['questionId'],
                "countryId" => $project->country_id,
                "project_id" => $project_id,
                "type" => $type,
            ]);

            $this->manageOptionApi($id, $project->country_id, $question['questionId'], $client_id, $project->surveyId, $project_id);

          }
        }
        $questions = DB::table('questions')->where('client_id',$client_id)->where('project_id',$project->id)->where('countryId',$project->country_id)->get();

        $data['questions'] = $questions;
        $data['success'] = true;
        return Response::json($data,200,[]);

    }    


    public function manageOptionApi($id, $country_id, $questionId, $client_id, $surveyId, $project_id){

        $check = DB::table('options')->where('countryid',$country_id)->where("questionId",$questionId)->delete();

        $optionData = Project::curl_fnt_option_data($name = null,$country_id,$questionId);

        if($optionData != 404){
          foreach($optionData['data'] as $option){

              DB::table('options')->insert([
                "question_id" => $id,
                "questionId" => $questionId,
                "answerId" => $option['answerId'],
                "answerTitle" => $option['answerTitle'],
                "answerEngTitle" => $option['answerEngTitle'],
                "option_name" => $option['answerEngTitle'],
                "client_id" => $client_id,
                "countryid" => $country_id,
                "project_id" => $project_id,
              ]);
            }

            $this->manageOptionAnswerApi($surveyId, $project_id);
        }
    }

    public function manageOptionAnswerApi($surveyId, $project_id){


        $optionAnswerData = Project::curl_fnt_option_answer_data($name = null,$surveyId);

        $optionAnswer = json_decode($optionAnswerData, true);


        if($optionAnswer != 404){
            if(isset($optionAnswer['data']) ? $optionAnswer['data'] : ""){
                foreach($optionAnswer['data'] as $key => $option){
                    if($key == 0){
                        foreach($option['target'] as $ky => $target){
                            $check = DB::table('questions')->where('project_id',$project_id)->where('questionId',$ky)->first();

                            if($check){
                                if($check->type == 3 || $check->type == 4){
                                    $check = DB::table('questions')->where('project_id',$project_id)->where('questionId',$ky)->update(["fill_up" => $target]);
                                } else {
                                    foreach($target as $tgt){
                                        DB::table('options')->where('questionId',$check->questionId)->where('answerId',$tgt)->update(["answer" => 1]);
                                    }

                                }
                            }
                        }
                    }
                }
            }
        }

        $data['message'] = "";
        $data['success'] = true;
        return Response::json($data,200,[]);

    }

    public function fetchQuestion(Request $request){

        $settings = DB::table('api_settings')->first();
        $client_id = $settings->client_id;
        $project_id = $request->project_id;

        $project = DB::table('projects')->where('id',$project_id)->first();

        $questions = DB::table('questions')->where('client_id',$client_id)->where('project_id',$project->id)->where('countryId',$project->country_id)->get();

        $data['questions'] = $questions;
        $data['success'] = true;
        return Response::json($data,200,[]);

    }

        // public function manageOption(Request $request){

    //     $questions = $request->questions;
    //     $project_id = $request->project_id;

    //     $settings = DB::table('api_settings')->first();
    //     $client_id = $settings->client_id;
    //     $name = $settings->api_name;

    //     $project = DB::table('projects')->where('id',$project_id)->first();

    //     foreach ($questions as $question) {

    //         $check = DB::table('options')->where('countryid',$project->country_id)->where("questionId",$question['questionId'])->delete();

    //         $optionData = Project::curl_fnt_option_data($name,$project->country_id,$question['questionId']);

    //         if($optionData != 404){
    //           foreach($optionData['data'] as $option){

    //               DB::table('options')->insert([
    //                 "question_id" => $question['id'],
    //                 "questionId" => $question['questionId'],
    //                 "answerId" => $option['answerId'],
    //                 "answerTitle" => $option['answerTitle'],
    //                 "answerEngTitle" => $option['answerEngTitle'],
    //                 "option_name" => $option['answerEngTitle'],
    //                 "client_id" => $client_id,
    //                 "countryid" => $project->country_id,
    //               ]);
    //             }
    //         }
    //     }

    //     $data['message'] = "";
    //     $data['success'] = true;
    //     return Response::json($data,200,[]);

    // }

    // public function manageOptionAnswer(Request $request){

    //     $project_id = $request->project_id;
    //     $project = DB::table('projects')->where('id',$project_id)->first();

    //     $settings = DB::table('api_settings')->first();
    //     $client_id = $settings->client_id;
    //     $name = $settings->api_name;


    //     $optionAnswerData = Project::curl_fnt_option_answer_data($name,$project->surveyId);

    //     $optionAnswer = json_decode($optionAnswerData, true);


    //     if($optionAnswer != 404){
    //         foreach($optionAnswer['data'] as $key => $option){
    //             if($key == 0){
    //                 foreach($option['target'] as $ky => $target){
    //                     $check = DB::table('questions')->where('project_id',$project_id)->where('questionId',$ky)->first();

    //                     if($check){
    //                         if($check->type == 3 || $check->type == 4){
    //                             $check = DB::table('questions')->where('project_id',$project_id)->where('questionId',$ky)->update(["fill_up" => $target]);
    //                         } else {
    //                             foreach($target as $tgt){
    //                                 DB::table('options')->where('questionId',$check->questionId)->where('answerId',$tgt)->update(["answer" => 1]);
    //                             }

    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $data['message'] = "";
    //     $data['success'] = true;
    //     return Response::json($data,200,[]);

    // }

}












