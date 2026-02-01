@extends('admin.layout')
@section('content')
<style type="text/css">
  .error-msg {
    color: red !important;
  }
</style>
<div class="container-flued mt-1 p-1" ng-controller="suplierCtrl" ng-init="init({{$project_id}})">
  <div class="card">
    <div class="card-body">
      <div class="mawin-content-label mg-b-5">
        <div class="row mt-3">
          <div class="col-md-6">
            <h3> Supliers</h3>
          </div>
          <div class="col-md-6 text-right" style="">
            <a href="#" ng-click="addSuplier({{$project_id}})" class="btn btn-primary  ">Add </a>
            <a href="{{url('/projects/add/'.$project_id)}}" class="btn btn-warning  ">Back </a>
          </div>
        </div>
        <div class="alert alert-info" ng-if="loading">Loading....</div>
      </div>
    </div>
  </div>
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
                    <th >SN</th>
                    <th>ID</th>
                    <th>Panel</th>
                    <th>Status</th>
                    <th>Hits</th>
                    <th>Qouta Full</th>
                    <th>Completed</th>
                    <th>Dis Qualified</th>
                    <th>Security Term</th>
                    <th>IR</th>
                    <th>CPC</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="supplier in dataset track by $index">
                    <td>@{{ $index+1 }}</td>
                    <td>@{{supplier.id}}</td>
                    <td>@{{supplier.vendorName ? supplier.vendorName : "Internal Team"}}</td>
                    <td>@{{supplier.showStatus}}</td>
                    <td>@{{supplier.hits}}</td>

                    <td>
                      <a class="btn btn-light  btn-sm" ng-click="viewSurveyDetails(supplier,3)">@{{supplier.quota_full}}</a>
                    </td>

                    <td>
                      <a class="btn btn-light  btn-sm" ng-click="viewSurveyDetails(supplier,1)">
                      @{{supplier.complete}}</a>
                    </td>

                    <td>
                      <a class="btn btn-light  btn-sm" ng-click="viewSurveyDetails(supplier,2)">
                      @{{supplier.disqualify}}</a>
                    </td>

                    <td>
                      <a class="btn btn-light  btn-sm" ng-click="viewSurveyDetails(supplier,4)">
                      @{{supplier.securityTerm}}</a>
                    </td>

                    <td>@{{supplier.ir}} %</td>
                    <td>@{{supplier.cost_per_complete}}</td>
                    <td>
                      <span class="ml-auto">
                      <button ng-click="viewSurveyDetails(supplier,0)" class="btn btn-info btn-sm">View</button>

                      <button ng-click="editSuplier(supplier)" class="btn btn-primary btn-sm">Edit</button>

                      <button  ng-click=removeSuplier(supplier.id)  class="btn btn-danger btn-sm">Delete</button>
                      </span>
                    </td>
                  </tr>
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
  @include('admin.suppliers.model')
</div>
@endsection