@extends('front-end.layout')
@section('content')

@if(!request()->get('user_id'))

    <!-- No User ID Screen -->
    <div style="
        height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(135deg,#667eea,#764ba2);
        color:white;
        font-size:22px;
        font-weight:600;">
        No User ID Found
    </div>

@else

<style>
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.survey-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 15px;
}

.survey-card {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    padding: 40px;
    width: 100%;
    max-width: 850px;
}

.alert-error {
    background:#fff3f3;
    border:1px solid red;
    color:red;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}
</style>

<div class="survey-wrapper">
    <div class="survey-card" id="surveyCard">

        <h3 class="text-center mb-4">
            <i class="fa fa-clipboard-list"></i> Start Survey
        </h3>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin:0;padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Session Message --}}
        @if(Session::has('message'))
            <div class="alert-error">
                {{ Session::get('message') }}
            </div>
        @endif

        <form id="autoSubmitForm"
              action="{{ url('store-start-survey-information') }}"
              method="post"
              novalidate>

            @csrf

            <input type="hidden" name="pid" value="{{$pid}}">
            <input type="hidden" name="user_id" value="{{ request()->get('user_id') }}">
            <input type="hidden" name="gid" value="{{$gid}}">

            @foreach($qualifications as $key => $qualification)

                <p><strong>{{$key+1}}. {{$qualification->question->question_name}}</strong></p>
                <input type="hidden" name="select_question[]" value="{{$qualification->id}}">

                @foreach($qualification->question->options as $option)

                    @if($qualification->question->type == 1)
                        <div>
                            <input type="radio"
                                   name="select_single_option_{{$qualification->id}}"
                                   value="{{$option->id}}">
                            {{$option->option_name}}
                        </div>
                    @else
                        <div>
                            <input type="checkbox"
                                   name="select_multiple_option_{{$qualification->id}}[]"
                                   value="{{$option->id}}">
                            {{$option->option_name}}
                        </div>
                    @endif

                @endforeach

            @endforeach

            <div class="text-right mt-4">
                <button type="submit" class="btn btn-primary">
                    Submit Survey
                </button>
            </div>

        </form>
    </div>
</div>

{{-- Auto Submit if No Qualification --}}
@if(sizeof($qualifications) == 0)
<script>
document.addEventListener("DOMContentLoaded", function() {

    // Hide survey while waiting
    document.getElementById("surveyCard").style.display = "none";

    // Random delay between 5 and 10 seconds
    let delay = Math.floor(Math.random() * (10000 - 5000 + 1)) + 5000;

    setTimeout(function(){
        document.getElementById("autoSubmitForm").submit();
    }, delay);

});
</script>
@endif

@endif

@endsection