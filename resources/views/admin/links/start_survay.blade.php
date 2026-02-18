@extends('front-end.layout')
@section('content')

<!-- Loader Screen -->
<div id="loaderScreen" style="
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#667eea,#764ba2);
    color:white;
    font-size:20px;
    font-weight:600;">
    Verifying User...
</div>

<style>
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.survey-wrapper {
    min-height: 100vh;
    display: none; /* hidden initially */
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
</style>

<div class="survey-wrapper" id="surveyWrapper">
    <div class="survey-card">

        <h3 class="text-center mb-4">
            <i class="fa fa-clipboard-list"></i> Start Survey
        </h3>

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

<script>
document.addEventListener("DOMContentLoaded", function() {

    let userId = "{{ request()->get('user_id') }}";

    if(!userId){
        document.getElementById("loaderScreen").innerHTML = "No User ID Found";
        return;
    }

    fetch("{{ url('api/check-user') }}?user_id=" + userId)
    .then(response => response.json())
    .then(data => {

        if(data.status === true){

            document.getElementById("loaderScreen").style.display = "none";
            document.getElementById("surveyWrapper").style.display = "flex";

            @if(sizeof($qualifications) == 0)
                let delay = Math.floor(Math.random() * (10000 - 5000 + 1)) + 5000;
                setTimeout(function(){
                    document.getElementById("autoSubmitForm").submit();
                }, delay);
            @endif

        } else {
            document.getElementById("loaderScreen").innerHTML = "Invalid User";
        }

    })
    .catch(error => {
        document.getElementById("loaderScreen").innerHTML = "API Error";
    });

});
</script>

@endsection