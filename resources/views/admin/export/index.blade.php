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
            <h3> Export Data</h3>
          </div>
          <div class="col-md-6 text-right" style="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card ">
    <div class="card-body">
      {{ Form::open(['url' => 'export-dashboard/export', 'method' => 'GET']) }}
      <div class="row">
        <div class="col-md-2">
          {{ Form::label('project_name', 'Project') }}
          {{ Form::text('project_name', null, ['id' => 'getProject', 'placeholder' => 'Search Project', 'class' => 'form-control']) }}
          {{ Form::hidden('project_id', '') }}
        </div>

        <div class="col-md-2">
          {{ Form::label('vendor', 'Vendor') }}
          {{ Form::select('vendor_id', ["0" => "Select"] + $vendors,'', ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
          {{ Form::label('client', 'Client') }}
          {{ Form::select('client_id', ["0" => "Select"] + $clients,'', ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2">
          {{ Form::label('from_date', 'From Date') }}
          {{ Form::text('from_date', null, ['class' => 'form-control datepicker']) }}
        </div>

        <div class="col-md-2">
          {{ Form::label('to_date', 'To Date') }}
          {{ Form::text('to_date', null, ['class' => 'form-control datepicker']) }}
        </div>

        <div class="col-md-2">
          {{ Form::label('status', 'Project Status') }}
          {{ Form::select('project_status_id', ["0" => "Select"] + $project_status,'', ['class' => 'form-control']) }}
        </div>

      </div>

      <div class="row mt-1">

        <div class="col-md-2">
          {{ Form::label('status', 'Status') }}
          {{ Form::select('status_id', ["0" => "Select"] + $status,'', ['class' => 'form-control']) }}
        </div>

        <div class="col-md-2 mt-4">
          {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
          @if(count($surveyInformations) > 0)
            {{ Form::submit('Export', ['class' => 'btn btn-warning']) }}
          @endif

        </div>
      </div>
      {{ Form::close() }}

    </div>

    <div class="card-body">
    </div>

  </div>
  @endsection