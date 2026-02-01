<?php

namespace App\Console\Commands;

use App\Models\MailQueue;
use Illuminate\Console\Command;
use App\Models\Project;
use DB;

class FetchTorfaqData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:api_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Torfac Api Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $check = DB::table('projects')->where('copy_for_client', 1)->first();
        $project_ids = [];
        $clientData = Project::curl_fnt_mca_data_2('test');
        $projectData = json_decode($clientData, true);
        if ($projectData) {
            foreach ($projectData['data'] as $key => $client) {
                if ($client['CPI'] >= $check->cpc) {
                    $flag = DB::table('projects')->where('surveyId', $client['surveyId'])->first();
                    if (!$flag) {
                        $project = new Project();
                        $project->surveyId = $client['surveyId'];
                        $project->parent_project_id = $check->parent_project_id;
                        $project->study_type = $check->study_type;
                        $project->country_id = $client['countryId'];
                        $project->language_id = $check->language_id;
                        $project->currency_id = $check->currency_id;
                        $project->cpc = $client['CPI'];
                        $project->survey_link = $client['entryLink'];
                        $project->survey_test_link = $check->survey_test_link;
                        $project->req_complete = $client['TotalRemaining'];
                        $project->loi = $client['LOI'];
                        $project->ir = $client['IR'];
                        $project->project_manager_id = $check->project_manager_id;
                        $project->sales_manager_id = $check->sales_manager_id;
                        $project->start_date = date("Y-m-d");
                        $project->notes = $check->notes;
                        $project->project_brief = $check->project_brief;
                        $project->status = $check->status;
                        $project->client_api_data = 1;
                        $project->client_id = $check->client_id;
                        $project->save();
                        $project->project_name = "TF" . $project->id;
                        $project->save();

                        $project_ids[] = $project->id;
                    }
                }
            }
        }
        $this->fetchApiQuestion($project_ids);
    }

    public static function fetchApiQuestion($project_ids)
    {
        foreach ($project_ids as $project_id) {
            $project = DB::table('projects')->where('id', $project_id)->first();
            $settings = DB::table('api_settings')->first();
            $client_id = $settings->client_id;
            $name = $settings->api_name;

            $clientData = Project::curl_fnt_country_wise_question_data($name, $project->country_id);
            $questionData = json_decode($clientData, true);
            if ($questionData) {
                DB::table('questions')->where('client_id', $client_id)->where('project_id', $project->id)->where('countryId', $project->country_id)->delete();

                foreach ($questionData['data'] as $question) {

                    if ($question['questionType'] == "Open End") $type = 3;
                    if ($question['questionType'] == "Single Select") $type = 1;
                    if ($question['questionType'] == "Multiple Select") $type = 2;
                    if ($question['questionType'] == "dummy") $type = 4;

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

                    self::manageOptionApi($id, $project->country_id, $question['questionId'], $client_id, $project->surveyId, $project_id);
                }
            }
        }
    }

    public static function manageOptionApi($id, $country_id, $questionId, $client_id, $surveyId, $project_id)
    {
        $check = DB::table('options')->where('countryid', $country_id)->where("questionId", $questionId)->delete();

        $optionData = Project::curl_fnt_option_data($name = null, $country_id, $questionId);

        if ($optionData != 404) {
            foreach ($optionData['data'] as $option) {

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

            self::manageOptionAnswerApi($surveyId, $project_id);
        }
    }

    public static function manageOptionAnswerApi($surveyId, $project_id)
    {
        $optionAnswerData = Project::curl_fnt_option_answer_data($name = null, $surveyId);

        $optionAnswer = json_decode($optionAnswerData, true);


        if ($optionAnswer != 404) {
            foreach ($optionAnswer['data'] as $key => $option) {
                if ($key == 0) {
                    foreach ($option['target'] as $ky => $target) {
                        $check = DB::table('questions')->where('project_id', $project_id)->where('questionId', $ky)->first();

                        if ($check) {
                            if ($check->type == 3 || $check->type == 4) {
                                $check = DB::table('questions')->where('project_id', $project_id)->where('questionId', $ky)->update(["fill_up" => $target]);
                            } else {
                                foreach ($target as $tgt) {
                                    DB::table('options')->where('questionId', $check->questionId)->where('answerId', $tgt)->update(["answer" => 1]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

