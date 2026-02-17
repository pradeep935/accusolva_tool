@extends('admin.layout')

@section('content')
<div class="container-flued mt-1 p-1">

  <div class="row">

  <div class="col-lg-12 col-md-12">
   <div class="card">
    <div class="card-body">
     <div class="main-content-label mg-b-5">
      <div class="row">
       <div class="col-md-6">
        <h3>Add Vendor</h3>
       </div>
       <div class="col-md-6 text-right" style="">
        <a href="{{url('vendors')}}" class="btn btn-warning " type="submit">Back</a>
       </div>
      </div>
      <hr>
     </div>
     <div class="row">
      <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
       <div class="card">
        <div class="card-body">
         <div class="main-content-label mg-b-5">

          @if(Session::has('failure'))
            <div class="alert alert-danger">
              <i class="fa fa-ban-circle"></i><strong>Failure!</strong> {{Session::get('failure')}}
            </div>
          @endif

         </div>
         @if(!isset($vendor))
          {{ Form::open(array('url' => '/vendors/store', 'method'=>'POST',"autocomplete"=>"off","class"=>"form-horizontal")) }}
          @else 
          {{ Form::open(array('url' => '/vendors/store/'.$vendor->id, 'method'=>'POST',"autocomplete"=>"off","class"=>"form-horizontal")) }}

          @endif

         <div class="row row-sm">

          <div class="col-lg-4 mt-3">
           <p class="mg-b-10"> Name <span class="text-danger">*</span></p>
           {{Form::text("vendorName",isset($vendor) ? $vendor->vendorName : '',["class"=>"form-control"])}}
          </div>

          <div class="col-lg-4 mt-3">
           <p class="mg-b-10"> Contact Person <span class="text-danger">*</span></p>
           {{Form::text("contactPerson",isset($vendor) ? $vendor->contactPerson : '',["class"=>"form-control"])}}
          </div>

          <div class="col-lg-4 mt-3">
           <p class="mg-b-10"> Contact <span class="text-danger">*</span></p>
           {{Form::text("contact",isset($vendor) ? $vendor->contact : '',["class"=>"form-control"])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10"> Email <span class="text-danger">*</span></p>
           {{Form::text("email",isset($vendor) ? $vendor->email : '',["class"=>"form-control"])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10"> Payment Terms <span class="text-danger">*</span></p>
           {{Form::select("paymentTerms",$paymentTerms,isset($vendor) ? $vendor->paymentTerms : '',["class"=>"form-control"])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10"> Complete Link <span class="text-danger">*</span></p>
           {{Form::textarea("completeLink",isset($vendor) ? $vendor->completeLink : '',["class"=>"form-control", "rows" => 3, "cols" => 3])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10"> Disqualify Link <span class="text-danger">*</span></p>
           {{Form::textarea("disqualifyLink",isset($vendor) ? $vendor->disqualifyLink : '',["class"=>"form-control", "rows" => 3, "cols" => 3])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10"> Qoutafull Link <span class="text-danger">*</span></p>
           {{Form::textarea("qoutafullLink",isset($vendor) ? $vendor->qoutafullLink : '',["class"=>"form-control", "rows" => 3, "cols" => 3])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10"> Security Term link <span class="text-danger">*</span></p>
           {{Form::textarea("securityTermlink",isset($vendor) ? $vendor->securityTermlink : '',["class"=>"form-control", "rows" => 3, "cols" => 3])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10">After Total Complete Link <span class="text-danger">*</span></p>
           {{Form::textarea("after_total_complete_link",isset($vendor) ? $vendor->after_total_complete_link : '',["class"=>"form-control", "rows" => 3, "cols" => 3])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10">After Total Disqualify Link <span class="text-danger">*</span></p>
           {{Form::textarea("after_total_disqualify_link",isset($vendor) ? $vendor->after_total_disqualify_link : '',["class"=>"form-control", "rows" => 3, "cols" => 3])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10">After Total Qoutafull Link <span class="text-danger">*</span></p>
           {{Form::textarea("after_total_qoutafull_link",isset($vendor) ? $vendor->after_total_qoutafull_link : '',["class"=>"form-control", "rows" => 3, "cols" => 3])}}
          </div>

          <div class="col-lg-6 mt-3">
           <p class="mg-b-10">After Total Security Term link <span class="text-danger">*</span></p>
           {{Form::textarea("after_total_security_term_link",isset($vendor) ? $vendor->after_total_security_term_link : '',["class"=>"form-control", "rows" => 3, "cols" => 3])}}
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
    <div class="card-footer">
     <div class="form-group col-lg-12">
      <button type="submit" class="  btn btn-primary ">Submit</button>
     </div>
    </div>
    {{ Form::close() }}
   </div>
  </div>


</div>
  
</div>


@endsection