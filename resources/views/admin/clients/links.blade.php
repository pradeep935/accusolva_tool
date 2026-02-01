@extends('admin.layout')

@section('content')
<div class="container-flued mt-1 p-1">
    

    <div class="row row-sm ">

        <div class="col-xl-12">
        <div class="card card-custom">            
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Client Redirect Links</h3>
                </div>
                
            </div>
        </div>
    </div>
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0 mt-2">All LINKS</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table id="example" class="table key-buttons text-md-nowrap  table-hover table-bordered " >
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">SN</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0" style="width:70%">Url</th>
                                    <th class="border-bottom-0 text-right">#</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th class="border-bottom-0">1</th>
                                    <th class="border-bottom-0">Complete</th>
                                    <th class="border-bottom-0">
                                        <input type="text" id="complete" class="form-control" value="{{url('/client-redirect-url?status=complete&uid=xxx')}}">
                                    </th>
                                    <th class="border-bottom-0 text-right">
                                        <button value="copy" class="btn btn-primary" onclick="copyToClipboardComplete('complete')">Copy</button>
                                    </th>
                                </tr>

                                <tr>
                                    <th class="border-bottom-0">2.</th>
                                    <th class="border-bottom-0">Disqualify</th>
                                    <th class="border-bottom-0" class="form-group">   
                                        <input type="text" id="disqualify" class="form-control" value="{{url('/client-redirect-url?status=disqualify&uid=xxx')}}">
                                    </th>
                                    
                                    <th class="border-bottom-0 text-right">
                                        <button value="copy" class="btn btn-primary" onclick="copyToClipboard('disqualify')">Copy</button>
                                    </th>
                                </tr>

                                <tr>
                                    <th class="border-bottom-0">3</th>
                                    <th class="border-bottom-0">Qouta Full</th>
                                    <th class="border-bottom-0"><input type="text" id="quotaFull" class="form-control" value="{{url('/client-redirect-url?status=quotaFull&uid=xxx')}}"></th>

                                    <th class="border-bottom-0 text-right">
                                        <button value="copy" id="quotaFull" class="btn btn-primary" onclick="copyToClipboardQuota('quotaFull')">Copy</button>
                                    </th>
                                </tr>

                                <tr>
                                    <th class="border-bottom-0">4</th>
                                    <th class="border-bottom-0">Security Term</th>
                                    <th class="border-bottom-0">
                                        <input type="text" id="securityTerm" class="form-control" value="{{url('/client-redirect-url?status=securityTerm&uid=xxx')}}"></th>
                                    <th class="border-bottom-0 text-right">
                                        <button value="copy" id="securityTerm" class="btn btn-primary" onclick="copyToClipboardsecurityTerm('securityTerm')">Copy</button>
                                    </th>
                                </tr>
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>

                    
    </div>

</div>



@endsection



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