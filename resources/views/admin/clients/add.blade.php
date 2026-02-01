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
        <h3>Add Client</h3>
       </div>
       <div class="col-md-6 text-right" style="">
        <a href="{{url('clients')}}" class="btn btn-warning" type="submit">Back</a>
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
         @if(!isset($client))
          {{ Form::open(array('url' => '/clients/store', 'method'=>'POST',"autocomplete"=>"off","class"=>"form-horizontal")) }}
          @else 
          {{ Form::open(array('url' => '/clients/store/'.$client->id, 'method'=>'POST',"autocomplete"=>"off","class"=>"form-horizontal")) }}

          @endif

         <div class="row row-sm">

          <div class="col-lg-4 mt-3">
           <p class="mg-b-10"> Name <span class="text-danger">*</span></p>
           {{Form::text("clientName",isset($client) ? $client->clientName : '',["class"=>"form-control"])}}
          </div>

          <div class="col-lg-4 mt-3">
           <p class="mg-b-10"> Contact Person <span class="text-danger">*</span></p>
           {{Form::text("contactPerson",isset($client) ? $client->contactPerson : '',["class"=>"form-control"])}}
          </div>

          <div class="col-lg-4 mt-3">
           <p class="mg-b-10"> Contact <span class="text-danger">*</span></p>
           {{Form::text("contact",isset($client) ? $client->contact : '',["class"=>"form-control"])}}
          </div>

          <div class="col-lg-4 mt-3">
           <p class="mg-b-10"> Email <span class="text-danger">*</span></p>
           {{Form::text("email",isset($client) ? $client->email : '',["class"=>"form-control"])}}
          </div>

          <div class="col-lg-4 mt-3">
           <p class="mg-b-10"> Payment Terms <span class="text-danger">*</span></p>
           {{Form::select("paymentTerms",$paymentTerms,isset($client) ? $client->paymentTerms : '',["class"=>"form-control"])}}
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