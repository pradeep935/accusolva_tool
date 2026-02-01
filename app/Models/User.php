<?php

namespace App\Models;

use DB, App\Models\MailQueue;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Session, Hash, Crypt, Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getClientName($user_id){
        $user = User::find($user_id);
        if($user){
            return str_replace(" ","_",$user->name);
        }else{

            return "";
        }
    }

    public static function getParentId(){
        // return (Auth::user()->privilege == 4)?Auth::user()->parent_user_id:Auth::id();
        return Auth::user()->parent_user_id;
    }

    public static function checkDisableChecker(){
        $parent_user = User::find(Auth::user()->parent_user_id);
        if($parent_user){
            return $parent_user->disable_checker == 0 ? false : true;
        } else {
            return false;
        }
    }

    public static function getPrivByRole($role){

        $privilege = 2;

        return $privilege;

    }

    public static function settingParams(){
        $params = DB::table('settings')->pluck('param')->toArray();
        return $params;
    }

    public static function getSettingParams($param){
        $param = DB::table('settings')->where('param',$param)->first();
        return $param;
    }


    public function getTypeName(){
        $values = User::getTypeOfClient();
        return isset($values[$this->type_of_client]) ? $values[$this->type_of_client] : "";
    }

    public function getVotingName(){
        $values = User::getTypeOfVoting();
        return isset($values[$this->type_of_voting]) ? $values[$this->type_of_voting] : "";
    }

    public function getRoleName(){
        $role = DB::table("user_roles")->where("id",$this->role)->first();
        if($role){
            return $role->role_name;
        } else {
            return "";
        }
    }

    public function CurrentPortfolioIds(){
        $com_ids = [];
        $com_ids_sql = DB::table("user_voting_company")->where("user_id",$this->id)->pluck("com_id");

        foreach ($com_ids_sql as $com_id) {
            $com_ids[] = $com_id;
        }
        return $com_ids;
    }

    public function sendWelcomeEmail($password){
        
        $mail = new MailQueue;
        $mail->mailto = $this->email;
        $mail->subject = "Fashion Tech - Registration Details";
        $mail->content = view("admin.mails.index",["type" => "registration", "user"=>$this, "password" => $password]);
        $mail->save();

    }

    public function sendForgetPasswordEmail($rand_pwd){
        
        $mail = new MailQueue;
        $mail->mailto = $this->email;
        $mail->subject = "Fashion Tech - Reset Password";
        $mail->content = view("admin.mails.index",["type" => "password_reset", "user"=>$this, "password" => $rand_pwd]);
        $mail->save();

    }


    public static function getRandPassword(){
        $string1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $string2 = "abcdefghijklmnopqrstuvwxyz";
        $string3 = "0123456789";
        $string4 = "$#@*^%";
        $string5 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789$#@*^%";

        $n = random_int(0, strlen($string1) - 1);
        $rand_pwd =  $string1[$n];

        for ($i=0; $i < 2; $i++) { 
            $n = random_int(0, strlen($string2) - 1);
            $rand_pwd .=  $string2[$n];
        }

        $n = random_int(0, strlen($string3) - 1);
        $rand_pwd .=  $string3[$n];

        $n = random_int(0, strlen($string4) - 1);
        $rand_pwd .=  $string4[$n];

        for ($i=0; $i < 3; $i++) { 
            $n = random_int(0, strlen($string5) - 1);
            $rand_pwd .=  $string5[$n];
        }

        return $rand_pwd;
    }

    public static function getNameFromNumber($num) {
        $numeric = ($num ) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num ) / 26);
        if ($num2 > 0) {
            return User::getNameFromNumber($num2) . $letter;
        } else {
            return $letter;
        }
    }



    public static function checkRole($role){

        $flag = true;
        $message = "";

        $role = DB::table("user_roles")->where("role_name",$role)->where("status",0)->first();
        if(!$role){
            $flag = false;
            $message .= "INVALID ROLE";
        }

        return [
            "status" => $flag,
            "message" => $message,
            "role" => $role
        ];

    }


    public static function checkExt(){
       return ["jpg","jpeg","png","JPG",'PNG',"JPEG"];
    }


    public static function encrypt($data){
        $encrypted = Crypt::encryptString($data);
        return $encrypted;
    }

    public static function decrypt(){
        $decrypted = Crypt::decryptString();
    }

    public static function parseUrl($data){
        $query = parse_url($data, PHP_URL_QUERY);
    }

    public static function pageAccess($access){
        
        $role_id = Auth::user()->role_id;
        $role = DB::table("client_user_priv")->where('user_type_id',$role_id)->first();
        $access_rights = explode(',', $role->access_right_id);


        // if($role_id == 1) return true;

        if(is_array($access)){
            if(in_array($access[0], $access_rights)){
                return true;
            } else {
                die("Not authorized");
            }
        } else {
            if(in_array($access, $access_rights)){
                return true;
            } else {
                die("Not authorized");
            }
        }
    }

    public static function convertDateShow($date){
        if(!$date){
            return "";
        } else {
            return date("d-M-Y",strtotime($date));
        }
    }

    public static function convertDate($date){
        if(!$date){
            return "";
        } else {
            return date("d-m-Y",strtotime($date));
        }
    }

    public static function convertDateToDB($date){

        if(!isset($date)){
            return null;
        }

        if(!$date){
            return null;
        } else {
            return date("Y-m-d",strtotime($date));
        }
    }

    public static function clientWiseAccess($param){
        $setting = DB::table("settings")->where('param',$param)->first();
        if($setting->value == 0){
            die("Not authorized");
        }
        return true;
    }
}
