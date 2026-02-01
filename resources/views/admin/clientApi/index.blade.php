@extends('admin.layout')
@section('content')
<style type="text/css">
  .error-msg {
    color: red !important;
  }
</style>
<div class="container-flued mt-1 p-1" ng-controller="clientApiDataCtrl" ng-init="init()">
  <div class="card">
    <div class="card-body">
      <div class="mawin-content-label mg-b-5">
        <div class="row mt-3">
          <div class="col-md-6">
            <h3>Client Data</h3>
          </div>
          <div class="col-md-6 text-right" style="">
            <a href="{{ url('/projects/add/1?test=1') }}" class="btn btn-warning  ">Project Setting </a>
            <a ng-click="fetchData()" class="btn btn-primary  ">Fetch Data </a>
            <a ng-click="apiSettings()" class="btn btn-info  ">API Settings </a>
            <a ng-click="apiCountries()" class="btn btn-dark  ">Fetch Countries </a>
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
          @if(session()->has('message'))
              <div class="alert alert-success">
                  {{ session()->get('message') }}
              </div>
          @endif
            <div table-paginate></div>
          
          <table class="table key-buttons text-md-nowrap  table-hover table-bordered">
            <thead>
              <tr >
                <th>SN <input type="checkbox" ng-click="selectAllProject()" ng-model="formData.select_all"> </th>
                <th>Client</th>
                <th>Survey Id</th>
                <th>Country</th>
                <th>CPI</th>
                <th>IR</th>
                <th>LOI</th>
                <th>Fetched</th>
                <th>Registered</th>
                <th>Status</th>
                <th class="text-right">#</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="survey in dataset track by $index" ng-style="survey.top_survey == 1 && {'color':'red', 'font-weight':'bold'}">

                <td>@{{$index+1}} <input type="checkbox" ng-checked="project_ids.indexOf(survey.id) > -1" ng-click="checkProject(survey.id)"></td>

                <td>@{{ survey.clientName }} </td>
                <td>@{{ survey.project_name }}</td>
                <td>@{{ survey.country_name }}</td>
                <td>@{{ survey.cpc }}</td>
                <td>@{{ survey.ir }}</td>
                <td>@{{ survey.loi }}</td>
                <td>@{{ survey.created_at }}</td>
                <td>@{{ survey.updated_at }}</td>
                <td>@{{ survey.status }}</td>
                <td class="text-right">
                  <a class="btn btn-danger bg-gradient-danger btn-sm" ng-click=removeClientProject(survey.id,$index) >X</a>
                  <a class="btn btn-primary bg-gradient-primary btn-sm" href="{{ url('projects/add') }}/@{{survey.id}}">Edit</a>

                  <a class="btn btn-sm" ng-class="{'btn-primary': survey.approved == 0, 'btn-danger': survey.approved != 0}" ng-click="changeClientProjectStatus(survey)" >@{{survey.approved == 0 ? "Approved" : "Disapproved"}}
                  </a>

                </td>
              </tr>
            </tbody>
          </table>


          <div ng-if="project_ids.length > 0">
            <button ng-disabled="processing_delete" type="button" ng-click="bulkOperation(1)" class="btn btn-danger">Delete <div class="spinner-border spinner-border-sm" role="status" ng-show="processing_delete"></div></button>

            <button ng-disabled="processing_approved" type="button" ng-click="bulkOperation(2)" class="btn btn-info">Approved <div class="spinner-border spinner-border-sm" role="status" ng-show="processing_approved"></div></button>
            
            <button ng-disabled="processing_disapproved" type="button" ng-click="bulkOperation(3)" class="btn btn-warning">Disapproved <div class="spinner-border spinner-border-sm" role="status" ng-show="processing_disapproved"></div></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('admin.clientApi.model')
</div>
@endsection