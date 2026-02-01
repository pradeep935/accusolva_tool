@extends('layouts.app')
@section('title', 'Roles')
@section('content')
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Links</h1>
    </div><hr>

    <table class="table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Status</th>
                <th>Url</th>
                <th>#</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <th>1</th>
                <th>Completion</th>
                <th>{{url('/survey-initiate?gid=xxx&pid=YYY&status=complete')}}</th>
                <th>1</th>
            </tr>

            <tr>
                <th>2.</th>
                <th>Disqualify</th>
                <th class="form-group">   
                    <input type="text" id="disqualify" class="form-control" value="{{url('/survey-initiate?gid=xxx&pid=YYY&status=disqualify')}}">
                </th>
                
                <th>
                    <button value="copy" onclick="copyToClipboard('disqualify')">Copy</button>
                </th>
            </tr>

            <tr>
                <th>3</th>
                <th>Qouta Full</th>
                <th>{{url('/survey-initiate?gid=xxx&pid=YYY&status=quotaFull')}}</th>

                <th>1</th>
            </tr>

            <tr>
                <th>4</th>
                <th>Security Term</th>
                <th>{{url('/survey-initiate?gid=xxx&pid=YYY&status=securityTerm')}}</th>
                <th>1</th>
            </tr>
        </tbody>

    </table>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function copyToClipboard() {
            document.getElementById('disqualify').select();
            document.execCommand('copy');
        
    }
    
</script>
