<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Clients;
use App\Models\User;
use Illuminate\Http\Request;
use Redirect, Validator, Session, DB;
use Input, Hash, Response;

class VendorController extends Controller
{

    public function index(){
        User::pageAccess(18);
        $accessRights = Session::get("access");
        $vendors = DB::table('vendors')->get();
        return view('admin.vendors.index', ["vendors" => $vendors, "accessRights" => $accessRights]);
    }

    public function add($id = 0){

        if($id == 0){
            User::pageAccess(15);
        } else {
            User::pageAccess(16);
        }

        $paymentTerms = Clients::paymentTerms();
        $vendor = Vendor::find($id);
        return view('admin.vendors.add',["paymentTerms" => $paymentTerms, "vendor" => $vendor]);
    }

    public function store(Request $request, $id = 0){

        $validator = Validator::make(
            [
                "vendorName" => $request->vendorName,
                "contactPerson" => $request->contactPerson,
                "contact" => $request->contact,
                "email" => $request->email,
                "paymentTerms" => $request->paymentTerms,
                
            ],
            [
                "vendorName" => "required|string",
                "contactPerson" => "required|string",
                "contact" => "required|integer",
                "email" => "required|email",
                "paymentTerms" => 'required',
            ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput()->with('failure',$validator->errors()->first());
        } else {
            if($id == 0){
                $vendor = new Vendor();
            } else {
                $vendor = Vendor::find($id);
            }

            $vendor->vendorName = $request->vendorName;
            $vendor->contactPerson = $request->contactPerson;
            $vendor->contact = $request->contact;
            $vendor->email = $request->email;
            $vendor->paymentTerms = $request->paymentTerms;
            $vendor->completeLink = $request->completeLink;
            $vendor->disqualifyLink = $request->disqualifyLink;
            $vendor->qoutafullLink = $request->qoutafullLink;
            $vendor->securityTermlink = $request->securityTermlink;
            $vendor->after_total_complete_link = $request->after_total_complete_link;
            $vendor->after_total_disqualify_link = $request->after_total_disqualify_link;
            $vendor->after_total_qoutafull_link = $request->after_total_qoutafull_link;
            $vendor->after_total_security_term_link = $request->after_total_security_term_link;
            $vendor->save();

            return Redirect::to('vendors')->with("message","Vendor was successfuly submitted");
        }
    }

    public function delete($id){
        User::pageAccess(17);
        $check = DB::table('vendors')->where('id',$id)->first();

        if($check->internal_panel != 1){
            DB::table('vendors')->where('id',$id)->delete();
        }
        return Redirect::to('vendors')->with("message","Vendor was successfuly delete");
    }
}
