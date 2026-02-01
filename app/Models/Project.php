<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Http;
class Project extends Model
{
    protected $table = 'projects';


    public static function getStudyTypes()
    {
        return [
            ['value' => '1', 'label' => 'B2B'],
            ['value' => '2', 'label' => 'B2C'],
            ['value' => '3', 'label' => 'Healthcare'],
            ['value' => '4', 'label' => 'ITDM'],
            ['value' => '5', 'label' => 'ADHOC'],
        ];
    }

    public static function getStatusOptions()
    {
        return [
            ['value' => '1', 'label' => 'Bidding'],
            ['value' => '2', 'label' => 'Testing'],
            ['value' => '3', 'label' => 'Running'],
            ['value' => '4', 'label' => 'Hold'],
            ['value' => '5', 'label' => 'Completed'],
            ['value' => '6', 'label' => 'Awaiting-Ids'],
            ['value' => '7', 'label' => 'Closed'],
        ];
    }

    public static function showStatusOptions()
    {
        return [
             1  => 'Bidding',
             2  => 'Testing',
             3  => 'Running',
             4  => 'Hold',
             5  => 'Completed',
             6  => 'Awaiting-Ids',
             7  => 'Closed',
        ];
    }    

    public static function StatusOptions(){
        return [
             0  => 'Drop',
             1  => 'complete',
             2  => 'disqualify',
             3  => 'quotaFull',
             4  => 'securityTerm',
        ];
    }

    public static function getSurveyStatusOptions(){
        return [
            ['value' => '0', 'label' => 'Drop'],
            ['value' => '1', 'label' => 'Complete'],
            ['value' => '2', 'label' => 'Disqualify'],
            ['value' => '3', 'label' => 'quotaFull'],
            ['value' => '4', 'label' => 'securityTerm']
        ];
    }

    public static function getDevices()
    {
        return [
            ['value' => '1', 'icon' => 'Monitor'],
            ['value' => '2', 'icon' => 'Smartphone '],
            ['value' => '3', 'icon' => 'Tablet'],
        ];
    }

    public static function dataToAskOnRedirect()
    {
        return [
            ['value' => '1', 'label' => ' E-Mail Address'],
            ['value' => '2', 'label' => ' Zip Code '],
            ['value' => '3', 'label' => ' Age'],
            ['value' => '4', 'label' => '  Gender'],
        ];
    }

    public static function getSecurityChecklist()
    {
        return [
            ['value' => '1', 'label' => 'Validate Country'],
            ['value' => '2', 'label' => 'Validate Start-end-IP'],
            ['value' => '3', 'label' => 'Validate Proxy'],
        ];
    }

    public static function zampilaAllocatedSurvey(){

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'ZAMP-KEY' => 'b9ZJiXDgbvrRwEoJJaFcWDVqAKmMStDF',
        ])->get('https://surveysupply.zamplia.com/api/v1/Surveys/GetAllocatedSurveys');

        $data = $response->json();

        if ($data['success'] && isset($data['result']['data'])) {
            $surveys = $data['result']['data'];
            return $surveys;
        } else {
            return [];
        }
    }   

    public static function zampilaTopPickSurveys(){
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'ZAMP-KEY' => 'b9ZJiXDgbvrRwEoJJaFcWDVqAKmMStDF',
        ])->get('https://surveysupply.zamplia.com/api/v1/Surveys/getTopPickSurveys');

        $data = $response->json();

        if ($response->successful() && isset($data['result']['data'])) {
            return $data['result']['data'];
        } else {
            return [];
        }
    }


}

    
    

