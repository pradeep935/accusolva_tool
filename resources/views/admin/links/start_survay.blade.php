@extends('front-end.layout')
@section('content')  
<style type="text/css">
  * {box-sizing: border-box;}
  /* Style the input container */
  .input-container {
  display: flex;
  width: 100%;
  margin-bottom: 15px;
  }
  /* Style the form icons */
  .icon {
  padding: 10px;
  background: dodgerblue;
  color: white;
  min-width: 50px;
  text-align: center;
  }
  /* Style the input fields */
  .input-field {
  width: 100%;
  padding: 10px;
  outline: none;
  }
  .input-field:focus {
  border: 2px solid dodgerblue;
  }
  /* Set a style for the submit button */
  .btn {
  background-color: dodgerblue;
  color: white;
  padding: 15px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
  }
  .btn:hover {
  opacity: 1;
  }
</style>
<div class="container mt-5 alert ">
  <div class="row" style="box-sizing: border-box;
    ">
    <div class="col-lg-12">
      <div class="card ">
        <div class="card-header pb-0">
          <div class="card-title mb-0">
            <h4>Start Survey </h4>
          </div>
          <hr>
          @if(Session::has('message'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background: white;border: 1px solid red;color:red;">
            <strong>{{ Session::get('message') }}</strong>
          </div>
          @endif
        </div>
        <div class="card-body">
          <div class="table-responsive">
            @if(sizeof($qualifications) > 0)<h5 class="text-danger ">Please Fill Following Requirements</h5>@endif
            <form action="{{ url('store-start-survey-information') }}" method="post">
              @csrf
              <input type="hidden" name="pid" value="{{$pid}}" id="contactPerson" class="form-control">
              <input type="hidden" name="user_id" value="{{ request()->get('user_id') }}" id="contactPerson" class="form-control">
              <input type="hidden" name="gid" value="{{$gid}}" id="contactPerson" class="form-control">
              @if(in_array(1,$openQuestion))
              <div class="input-container form-group">
                <i class="fa fa-envelope icon"></i>
                <input type="email" name="email" placeholder="PLEASE ENTER EMAIL" class="form-control"  required class="form-control">
              </div>
              @endif
              @if(in_array(2,$openQuestion))
              <div class="input-container form-group">
                <i class="fa fa-key icon"></i>
                <input type="text" name="zip" placeholder="PLEASE ENTER ZIP CODE" required class="form-control">
              </div>
              @endif
              @if(in_array(3,$openQuestion))
              <div class="input-container form-group">
                <i class="fa fa-child icon"></i>
                <input type="text" name="age" placeholder="PLEASE ENTER AGE" required class="form-control">
              </div>
              @endif
              @if(in_array(4,$openQuestion))
              <div class="input-container form-group">
                <i class="fa fa-user icon"></i>
                <input type="text" name="Gender" placeholder="PLEASE ENTER GENDER" required class="form-control">
              </div>
              @endif

              <table>
                @foreach($qualifications as $key => $qualification)
                  <tr>
                    <th>
                      <input type="hidden" name="select_question[]" value="{{$qualification->id}}" class="form-control">

                      {{$key+1}}. {{$qualification->question->question_name}}
                    </th>
                  </tr>
                  @foreach($qualification->question->options as $keyOp => $option)

                  <tr>
                    <td>{{$keyOp+1}}. {{$option->option_name}}</td>
                    <th class="form-group">
                      @if($qualification->question->type == 1)
                      <input type="radio" name="select_single_option_{{$qualification->id}}" value="{{$option->id}}" class="form-control">
                        @else  
                        <input type="checkbox" name="select_multiple_option_{{$qualification->id}}[]" value="{{$option->id}}" class="form-control">
                      @endif
                    </th>
                  </tr>

                  @endforeach

                @endforeach

              </table>
              <button class="btn btn-success mt-2 float-right" type="submit" value="Continue Shopping">Submit</button>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection