<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';

    public static function paymentTerms(){
        $paymentTerms = [
            "15" => "15 Days",
            "30" => "30 Days",
            "45" => "45 Days",
            "60" => "60 Days"
        ];
        return $paymentTerms;
    }
    
}

