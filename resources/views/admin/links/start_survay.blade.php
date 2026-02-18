@extends('front-end.layout')
@section('content')

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

    .survey-logo {
        text-align: center;
        margin-bottom: 20px;
    }

    .survey-logo img {
        height: 60px;
    }

    .survey-title {
        text-align: center;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }

    .survey-subtitle {
        text-align: center;
        font-size: 14px;
        color: #888;
        margin-bottom: 30px;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #ddd;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 8px rgba(102,126,234,0.3);
    }

    .input-icon {
        position: relative;
        margin-bottom: 15px;
    }

    .input-icon i {
        position: absolute;
        top: 14px;
        left: 15px;
        color: #667eea;
    }

    .input-icon input {
        padding-left: 40px;
    }

    table {
        width: 100%;
        margin-top: 20px;
    }

    table tr {
        border-bottom: 1px solid #eee;
    }

    table td, table th {
        padding: 10px;
    }

    .question-title {
        font-weight: 600;
        color: #444;
        padding-top: 20px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        border: none;
        transition: 0.3s;
        font-weight: 500;
    }

    .btn-submit:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .alert-custom {
        background: #fff3f3;
        border: 1px solid red;
        color: red;
        border-radius: 8px;
    }
</style>

<div class="survey-wrapper">
    <div class="survey-card">

        

        <h3 class="survey-title">
            <i class="fa fa-clipboard-list"></i> Start Survey
        </h3>

        <p class="survey-subtitle">
            Please complete the information below to continue
        </p>

        @if(Session::has('message'))
        <div class="alert alert-custom">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif

        @if(sizeof($qualifications) > 0)
            <h6 class="text-danger mb-3">Please Fill Following Requirements</h6>
        @endif

        <form id="autoSubmitForm" action="{{ url('store-start-survey-information') }}" method="post" novalidate>
            @csrf

            <input type="hidden" name="pid" value="{{$pid}}">
            <input type="hidden" name="user_id" value="{{ request()->get('user_id') }}">
            <input type="hidden" name="gid" value="{{$gid}}">

            @if(in_array(1,$openQuestion))
            <div class="input-icon">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter Email" class="form-control" required>
            </div>
            @endif

            @if(in_array(2,$openQuestion))
            <div class="input-icon">
                <i class="fa fa-map-pin"></i>
                <input type="text" name="zip" placeholder="Enter ZIP Code" class="form-control" required>
            </div>
            @endif

            @if(in_array(3,$openQuestion))
            <div class="input-icon">
                <i class="fa fa-birthday-cake"></i>
                <input type="text" name="age" placeholder="Enter Age" class="form-control" required>
            </div>
            @endif

            @if(in_array(4,$openQuestion))
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input type="text" name="Gender" placeholder="Enter Gender" class="form-control" required>
            </div>
            @endif


            <table>
                @foreach($qualifications as $key => $qualification)

                <tr>
                    <td colspan="2" class="question-title">
                        {{$key+1}}. {{$qualification->question->question_name}}
                        <input type="hidden" name="select_question[]" value="{{$qualification->id}}">
                    </td>
                </tr>

                @foreach($qualification->question->options as $keyOp => $option)

                <tr>
                    <td>{{$keyOp+1}}. {{$option->option_name}}</td>
                    <td>
                        @if($qualification->question->type == 1)
                        <input type="radio" name="select_single_option_{{$qualification->id}}" value="{{$option->id}}">
                        @else  
                        <input type="checkbox" name="select_multiple_option_{{$qualification->id}}[]" value="{{$option->id}}">
                        @endif
                    </td>
                </tr>

                @endforeach
                @endforeach
            </table>

            <div class="text-right mt-4">
                <button type="submit" class="btn-submit">
                    <i class="fa fa-paper-plane"></i> Submit Survey
                </button>
            </div>

        </form>
    </div>
</div>
@if(sizeof($qualifications) == 0)
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("autoSubmitForm").submit();
});
</script>
@endif
@endsection