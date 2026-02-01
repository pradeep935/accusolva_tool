@extends('admin.layout')
@section('content')
<style type="text/css">
  .error-msg {
  color: red !important;
  }
</style>
<div class="container-flued mt-1 p-1">
<div class="card">
  <div class="card-body">
    <div class="mawin-content-label mg-b-5">
      <div class="row mt-3">
        <div class="col-md-6">
          <h3> Reconcile</h3>
        </div>
        <div class="col-md-6 text-right" style="">
          <a href="{{url('/projects/add/'.$project_id)}}" class="btn btn-warning  ">Back </a>
        </div>
      </div>
      <div class="alert alert-info" ng-if="loading">Loading....</div>
    </div>
  </div>
</div>
<div class="card ">
  <div class="card-body">
    {{ Form::open(array('url' => '/re-concile/'.$project_id, 'method'=>'get',"autocomplete"=>"off","class"=>"form-horizontal")) }}
    <div class="row">
      <div class="col-md-12 form-group">
        {{Form::textarea("ref_id",'',["class"=>"form-control", "rows" => 3, "cols" => 3])}}
      </div>

      <div class="col-md-2">
        <button class="btn btn-primary" type="submit"> Search</button>
      </div>
    </div>
    {{Form::close()}}
  </div>
  @if(sizeof($surveyInformations )> 0)
    <div class="row row-sm ">
      <div class="col-md-12 col-xl-12">
        <div class="card overflow-hidden review-project">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <i class="mdi mdi-dots-horizontal text-gray"></i>
            </div>
            <div class="row">
              <div class="col-md-12" style="overflow:scroll; ">
                <table class="table key-buttons text-md-nowrap  table-hover table-bordered " >
                  <thead>
                    <tr >
                      <th style="font-weight: bold !important;font-size: 13px;" >SN</th>
                      <th style="font-weight: bold !important;font-size: 13px;">Project ID</th>
                      <th style="font-weight: bold !important;font-size: 13px;">Refrel Id</th>
                      <th style="font-weight: bold !important;font-size: 13px;">UID </th>
                      <th style="font-weight: bold !important;font-size: 13px;">Suplier Id</th>
                      <th style="font-weight: bold !important;font-size: 13px;">Status</th>
                      <th style="font-weight: bold !important;font-size: 13px;">Suplier Name</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($surveyInformations as $key => $surveyInformation)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{$surveyInformation->pid}}</td>
                      <td>{{$surveyInformation->ref_id}}</td>
                      <td>{{$surveyInformation->user_id}}</td>
                      <td>{{$surveyInformation->gid}}</td>
                      <td>{{$surveyInformation->status}}</td>
                      <td>{{$surveyInformation->vendorName}}</td>
                    </tr>
                    @endforeach
                    <tr>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection