<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Redirect, Validator, Session, DB;
use Input, Hash, Response;
use App\Models\User;

class ClientController extends Controller
{

    public function index(){

        User::pageAccess(14);
        $accessRights = Session::get("access");

        $clients = DB::table('clients')->get();
        return view('admin.clients.index', ["clients" => $clients, "accessRights" => $accessRights]);
    }

    public function add($id = 0){

        if($id == 0){
            User::pageAccess(11);
        } else {
            User::pageAccess(12);
        }

        $paymentTerms = Clients::paymentTerms();
        $client = Clients::find($id);
        return view('admin.clients.add',["paymentTerms" => $paymentTerms, "client" => $client]);
    }

    public function store(Request $request, $id = 0){

        $validator = Validator::make(
            [
                "clientName" => $request->clientName,
                "contactPerson" => $request->contactPerson,
                "contact" => $request->contact,
                "email" => $request->email,
                "paymentTerms" => $request->paymentTerms,
                
            ],
            [
                "clientName" => "required|string",
                "contactPerson" => "required|string",
                "contact" => "required|integer",
                "email" => "required|email",
                "paymentTerms" => 'required',
            ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput()->with('failure',$validator->errors()->first());
        } else {
            if($id == 0){
                $client = new Clients();
            } else {
                $client = Clients::find($id);
            }

            $client->clientName = $request->clientName;
            $client->contactPerson = $request->contactPerson;
            $client->contact = $request->contact;
            $client->email = $request->email;
            $client->paymentTerms = $request->paymentTerms;
            $client->save();

            return Redirect::to('clients')->with("message","Client was successfuly submitted");
        }
    }

    public function delete($id){
        User::pageAccess(13);
        DB::table('clients')->where('id',$id)->delete();
        return Redirect::to('clients')->with("message","Client was successfuly delete");
    }

    public function links(Request $request){
        User::pageAccess(19);
        return view('admin.clients.links',["pid" => $request->p_id]);
    }
}
