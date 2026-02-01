<?php

namespace App\Console\Commands;

use App\Models\MailQueue;
use Illuminate\Console\Command;
use App\Models\Project;
use DB;
use Http;

class ZampilaCountLanguage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zampila:country';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Zampila country and lnguage';

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

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'ZAMP-KEY' => 'b9ZJiXDgbvrRwEoJJaFcWDVqAKmMStDF',
        ])->get('https://surveysupply.zamplia.com/api/v1/Attributes/GetLanguages');

        $data = $response->json();

        if ($data['success'] && isset($data['result']['data'])) {
            $languages = $data['result']['data'];
        } else {
            return [];
        }
    
        foreach ($languages as $language) {
            $test = DB::table('languages_data')->where('LanguageId',$language['LanguageId'])->first();
            if(!$test){
                DB::table('languages_data')->insert([
                    "LanguageId" => $language['LanguageId'],
                    "LanguageCode" => $language['LanguageCode'],
                    "Country" => $language['Country'],
                    "CountryCode" => $language['CountryCode'],
                ]);
            }
        }


        $records = DB::table('languages_data')->get();

        foreach ($records as $record) {
            $l = DB::table('languages')->where("LanguageId",$record->LanguageId)->first();
            if(!$l){
                DB::table('languages')->insert([
                    "LanguageId" => $record->LanguageId,
                    "language_code" => $record->LanguageCode,
                    "language_name" => $record->Country,
                ]);
            }
            
            $c = DB::table('countries')->where("LanguageId",$record->LanguageId)->first();
            if(!$c){
                DB::table('countries')->insert([
                    "LanguageId" => $record->LanguageId,
                    "nameCode" => $record->LanguageCode,
                    "name" => $record->Country,
                ]);
            }
        }
    }
}

