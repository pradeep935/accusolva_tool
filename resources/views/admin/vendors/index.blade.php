@extends('admin.layout')

@section('content')
<div class="container-flued mt-1 p-1">
	

	<div class="row row-sm ">

		<div class="col-xl-12">
        <div class="card card-custom">            
            <div class="card-header mt-3">
            	<div class="row">
	            	<div class="card-title col-md-9">
	                    <h3 class="card-label">Vendors</h3>
	                </div>
	                <div class="card-toolbar text-right col-md-3">
                        @if(in_array(15, $accessRights))

							<a href="{{url('/vendors/add')}}" class="btn btn-info bg-gradient-info ">Add </a>
						@endif

	                </div>
            		
            	</div>
                
                
            </div>
        </div>
    </div>
    <hr />
		<div class="col-xl-12">
			<div class="card mg-b-20">
				<div class="card-header pb-0">
					<div class="d-flex justify-content-between">
						<h4 class="card-title mg-b-0 mt-2">All Vendors</h4>
						<i class="mdi mdi-dots-horizontal text-gray"></i>
					</div>
					<!-- <p class="tx-12 text-muted mb-2">Example of Azira Bordered Table.. <a href="#">Learn more</a></p> -->
				</div>
				<div class="card-body">
					@if(Session::has('message'))
			            <div class="alert alert-danger">
			              <i class="fa fa-ban-circle"></i><strong>message!</strong> {{Session::get('message')}}
			            </div>
			         @endif
					<div class="table-responsive">
						<table id="example" class="table key-buttons text-md-nowrap  table-hover table-bordered " >
							<thead>
								<tr>
                					
									<th class="border-bottom-0">SN</th>
									<th class="border-bottom-0">Name</th>
									<th class="border-bottom-0">Email</th>
									<th class="border-bottom-0">Contact Person</th>
									<th class="border-bottom-0">Number</th>
									<th class="border-bottom-0">Payment Term</th>
									<th class="border-bottom-0">#</th>
								</tr>
							</thead>
							<tbody>
								

	        					@foreach($vendors as $key => $vendor)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$vendor->vendorName}}</td>
									<td>{{$vendor->email}}</td>
									<td>{{$vendor->contactPerson}}</td>
									<td>{{$vendor->contact}}</td>
									<td>{{$vendor->paymentTerms}}</td>
									<td>
										<span class="ml-auto">
                        					@if(in_array(16, $accessRights))
												<a href="{{ url('vendors/add/'.$vendor->id) }}" class="btn btn-primary bg-gradient-primary btn-sm">Edit</a>
											@endif

                        					@if(in_array(17, $accessRights) && $vendor->internal_panel != 1)
												<a href="{{ url('vendors/delete/'.$vendor->id) }}" onclick="return confirm('Are you sure ?')"class="btn btn-danger bg-gradient-danger btn-sm">Delete</a>
											@endif
										</span>
									</td>

									
								</tr>
								@endforeach
								

							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>

					
	</div>

</div>

@endsection