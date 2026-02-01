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
                <th>
                    <input type="text" id="complete" class="form-control" value="{{url('/survey-initiate?uid=xxx&gid=zzz&pid=yyy&status=complete')}}">
                </th>
                <th>
                    <button value="copy" class="btn btn-primary" onclick="copyToClipboardComplete('complete')">Copy</button>
                </th>
            </tr>

            <tr>
                <th>2.</th>
                <th>Disqualify</th>
                <th class="form-group">   
                    <input type="text" id="disqualify" class="form-control" value="{{url('/survey-initiate?uid=xxx&gid=zzz&pid=yyy&status=disqualify')}}">
                </th>
                
                <th>
                    <button value="copy" class="btn btn-primary" onclick="copyToClipboard('disqualify')">Copy</button>
                </th>
            </tr>

            <tr>
                <th>3</th>
                <th>Qouta Full</th>
                <th><input type="text" id="quotaFull" class="form-control" value="{{url('/survey-initiate?uid=xxx&gid=zzz&pid=yyy&status=quota_full')}}"></th>

                <th>
                    <button value="copy" id="quotaFull" class="btn btn-primary" onclick="copyToClipboardQuota('quotaFull')">Copy</button>
                </th>
            </tr>

            <tr>
                <th>4</th>
                <th>Security Term</th>
                <th>
                    <input type="text" id="securityTerm" class="form-control" value="{{url('/survey-initiate?uid=xxx&gid=zzz&pid=yyy&status=security')}}"></th>
                <th>
                    <button value="copy" id="securityTerm" class="btn btn-primary" onclick="copyToClipboardsecurityTerm('securityTerm')">Copy</button>
                </th>
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

    function copyToClipboardQuota() {
        document.getElementById('quotaFull').select();
        document.execCommand('copy');
    }

    function copyToClipboardsecurityTerm() {
        document.getElementById('securityTerm').select();
        document.execCommand('copy');
    }

    function copyToClipboardComplete() {
        document.getElementById('complete').select();
        document.execCommand('copy');
    }
    
</script>
