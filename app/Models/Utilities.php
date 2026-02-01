<?php

namespace App\Models;

class Utilities
{

    public static function getRegex($type){

        switch ($type){
            case "password_pat":
            return '/^(?=.*\d)(?=.*[A-Z])(?=.*[~!@#$%&_^*]).{8,}$/';

            case "groupno":
            return '/^([0-9A-Za-z,]+)$/';

            case "emailinit":
            return "/^([0-9A-Za-z\.\+']+)$/";

            case "input_fix":
            return "/^([0-9A-Za-z _\-]+)$/";

            case "adid":
            return "/^([a-zA-Z0-9]+)$/";

            case "user_name":
            return "/^([a-zA-Z ']+)$/";

            case "alphanumeric":
            return "/^([a-zA-Z0-9]+)$/";

            case "mobile":
            return "/^([0-9\+]+)$/";

            default:
            return "";
        }

    }

}

