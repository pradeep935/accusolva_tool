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
                <h3>Access Rights</h3>
              </div>
              <div class="col-md-6 text-right">
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
                  {{ Form::open(["url"=>"/store-right", "method"=>"post"]) }}
                  @foreach($user_types as $user_type)
                  <div class="row">
                    <div class="col-md-3 form-group">
                      {{$user_type->name}}
                    </div>
                    <div class="col-md-9 form-group">
                      @foreach($access_rights as $access_right)
                      {{Form::checkbox('access_'.$user_type->id.'[]',$access_right->id,in_array($access_right->id,$user_type->access_right_id) ) }} {{$access_right->access}} &nbsp;&nbsp;&nbsp;
                      @endforeach
                    </div>
                  </div>
                  <hr>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
            <div class="form-group col-lg-12">
              <button type="submit" class="  btn btn-primary ">Submit</button>
            </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection