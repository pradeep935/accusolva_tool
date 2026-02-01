@extends('admin.layout')
@section('content')
<style type="text/css">
  .error-msg {
    color: red !important;
  }
</style>
<div class="container-flued mt-1 p-1" ng-controller="qualificationCtrl" ng-init="init({{$project_id}})">
  <div class="card">
    <div class="card-body">
      <div class="mawin-content-label mg-b-5">
        <div class="row mt-3">
          <div class="col-md-6">
            <h3>Qualifications</h3>
          </div>
          <div class="col-md-6 text-right" style="">
            <a href="#" ng-click="addQalification()" class="btn btn-primary  ">Add </a>
            <!-- <a href="#" ng-click="fetchQuestions()" class="btn btn-info">Fetch Api Question</a> -->
            <a href="{{url('/projects/add/'.$project_id)}}" class="btn btn-warning  ">Back </a>
          </div>
        </div>
        <div class="alert alert-info" ng-if="loading">Loading....</div>
        <div class="alert alert-info" ng-if="question_processing">Loading....</div>
      </div>
    </div>
  </div>
  <div class="row row-sm ">
    <div class="col-md-12 col-xl-12">
      <div class="card overflow-hidden review-project">
        <div class="card-body">
          <table class="table key-buttons text-md-nowrap  table-hover table-bordered " >
            <thead>
              <tr >
                <th style="width : 25px;">SN</th>
                <th>Question</th>
                <th>Option</th>
                <th>Answer</th>
                <th style="width : 130px;" class="text-right">#</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat="question in dataset track by $index" >
                <td>@{{ $index+1 }}</td>

                <td>@{{question.question_name}}</td>
                <td>@{{question.optionCheck ? "Yes" : "No"}}</td>
                <td>@{{question.optionAnswerCheck ? "Yes" : "No"}}</td>
                <td class="text-right">
                  <button ng-click="editQalification(question)" class="btn btn-primary btn-sm">Edit</button>
                  <button  ng-click=removeQualification(question.id,$index) class="btn btn-danger btn-sm">Delete</button>
                </td>
              </tr>
              <tr>
              </tr>
            </tbody>
          </table>
          <div class="col-md-6">
            <button  ng-click=applyQualification() class="btn btn-info btn-sm" ng-if="question_ids.length > 0">Apply Qualification</button>

          </div>
        </div>
      </div>
    </div>
  </div>
  @include('admin.qualification.model')
</div>
@endsection